<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookingController extends Controller
{
    private const CHECKOUT_SESSION_KEY = 'booking_checkout';

    public function myBookings(Request $request): View
    {
        $user = $request->user();

        return view('front.my-bookings', [
            'bookings' => Booking::with(['room.roomType', 'payment'])
                ->paid()
                ->where(function ($query) use ($user): void {
                    $query->where('user_id', $user->id)
                        ->orWhere('guest_email', $user->email);
                })
                ->latest('id')
                ->paginate(10),
        ]);
    }

    public function cancelMine(Request $request, Booking $booking): RedirectResponse
    {
        $user = $request->user();
        $belongsToUser = $booking->user_id === $user->id || $booking->guest_email === $user->email;

        abort_unless($belongsToUser, 403);

        if ($booking->status !== 'confirmed') {
            return back()->with('success', 'Only confirmed bookings can be cancelled.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled successfully.');
    }

    public function showCustomerBooking(Request $request, Booking $booking): View
    {
        $user = $request->user();
        $ownsBooking = $booking->user_id === $user->id || $booking->guest_email === $user->email;

        abort_unless($ownsBooking, 403);

        $booking->load(['room.roomType', 'payment']);
        abort_unless($booking->payment?->status === 'paid', 404);

        return view('front.bookings.show', [
            'booking' => $booking,
        ]);
    }

    public function index(): View
    {
        $bookings = Booking::with(['user', 'room.roomType'])
            ->paid()
            ->when(request('status'), fn($query, $status) => $query->where('status', $status))
            ->when(request('date_from'), fn($query, $date) => $query->whereDate('check_in', '>=', $date))
            ->when(request('date_to'), fn($query, $date) => $query->whereDate('check_out', '<=', $date))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.bookings.index', [
            'bookings' => $bookings,
        ]);
    }
    public function create(): View
    {
        return view('admin.bookings.create', [
            'rooms' => Room::with('roomType')->get(),
            'users' => User::all(),
        ]);
    }

    public function show(Booking $booking): View
    {
        return view('admin.bookings.show', [
            'booking' => $booking->load(['user', 'room.roomType', 'payment.bankTransfer']),
        ]);
    }

    public function edit(Booking $booking): View
    {
        return view('admin.bookings.edit', [
            'booking' => $booking->load(['user', 'room.roomType', 'payment']),
            'rooms' => Room::with('roomType')->orderBy('room_number')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'room_id' => ['required', 'exists:rooms,id'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'adults' => ['required', 'integer', 'min:1'],
            'children' => ['required', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['confirmed'])],
        ]);

        DB::transaction(function () use (&$validated, $request): void {
            $room = Room::with('roomType')
                ->whereKey($request->room_id)
                ->lockForUpdate()
                ->firstOrFail();
            $this->ensureRoomIsAvailable($room, $request->check_in, $request->check_out);

            $nights = $this->calculateNights($request->check_in, $request->check_out);

            $validated['total_price'] = $nights * $room->roomType->price_per_night;

            $booking = Booking::create($validated);
            $booking->payment()->create([
                'amount' => $booking->total_price,
                'currency' => 'USD',
                'method' => 'credit_card',
                'payment_setting_id' => null,
                'transaction_id' => 'ADMIN-' . Str::upper(Str::random(10)),
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        });

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    public function storeGuest(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'room_id' => ['required', 'exists:rooms,id'],
            'special_request' => ['nullable', 'string', 'max:1000'],
        ]);

        $checkout = DB::transaction(function () use ($request, $validated): array {
            $room = Room::with('roomType')
                ->whereKey($request->room_id)
                ->lockForUpdate()
                ->firstOrFail();
            $this->ensureRoomIsAvailable($room, $request->check_in, $request->check_out);

            $nights = $this->calculateNights($request->check_in, $request->check_out);

            $booking = [
                'guest_name' => $validated['name'],
                'guest_email' => $validated['email'],
                'room_id' => $request->room_id,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'adults' => $room->roomType->capacity_adults,
                'children' => $room->roomType->capacity_children,
                'special_request' => $request->special_request,
                'total_price' => $nights * $room->roomType->price_per_night,
                'status' => 'confirmed',
            ];

            if (auth()->check()) {
                $booking['user_id'] = auth()->id();
            }

            return $booking;
        });

        $request->session()->put(self::CHECKOUT_SESSION_KEY, $checkout);

        return redirect()
            ->route('bookings.payment.show')
            ->with('success', 'Please complete payment to save and confirm your booking.');
    }

    public function showPayment(Request $request): View|RedirectResponse
    {
        $checkout = $request->session()->get(self::CHECKOUT_SESSION_KEY);

        if (! is_array($checkout)) {
            return redirect()
                ->route('booking')
                ->with('success', 'Start a booking first. No booking is saved until payment succeeds.');
        }

        $room = Room::with('roomType')->find($checkout['room_id']);
        if (! $room) {
            $request->session()->forget(self::CHECKOUT_SESSION_KEY);

            return redirect()
                ->route('booking')
                ->withErrors(['room_id' => 'The selected room is no longer available.']);
        }

        $booking = new Booking($checkout);
        $booking->setRelation('room', $room);
        $booking->check_in = Carbon::parse($checkout['check_in']);
        $booking->check_out = Carbon::parse($checkout['check_out']);

        return view('front.payment', [
            'booking' => $booking,
            'paymentMethods' => collect(Payment::METHODS)->except('bank_transfer')->all(),
            'bankTransfers' => collect(),
        ]);
    }

    public function storePayment(Request $request): RedirectResponse
    {
        $checkout = $request->session()->get(self::CHECKOUT_SESSION_KEY);
        if (! is_array($checkout)) {
            return redirect()
                ->route('booking')
                ->with('success', 'Start a booking first. No booking is saved until payment succeeds.');
        }

        $cardMethods = ['credit_card', 'visa_card', 'mastercard'];
        $paymentMethods = collect(Payment::METHODS)->except('bank_transfer')->keys()->all();

        $validated = $request->validate([
            'method' => ['required', Rule::in($paymentMethods)],
            'card_name' => [Rule::requiredIf(fn() => in_array($request->method, $cardMethods, true)), 'nullable', 'string', 'max:255'],
            'card_number' => [Rule::requiredIf(fn() => in_array($request->method, $cardMethods, true)), 'nullable', 'regex:/^[0-9 ]{13,23}$/'],
            'card_expiry' => [Rule::requiredIf(fn() => in_array($request->method, $cardMethods, true)), 'nullable', 'regex:/^(0[1-9]|1[0-2])\/[0-9]{2}$/'],
            'card_cvv' => [Rule::requiredIf(fn() => in_array($request->method, $cardMethods, true)), 'nullable', 'digits_between:3,4'],
        ]);

        $booking = DB::transaction(function () use ($checkout, $validated): Booking {
            $room = Room::with('roomType')
                ->whereKey($checkout['room_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $this->ensureRoomIsAvailable($room, $checkout['check_in'], $checkout['check_out']);

            $booking = Booking::create($checkout);

            $booking->payment()->create([
                'amount' => $booking->total_price,
                'currency' => 'USD',
                'method' => $validated['method'],
                'payment_setting_id' => null,
                'bank_transfer_id' => null,
                'transaction_id' => 'PAY-' . Str::upper(Str::random(10)),
                'receipt_path' => null,
                'bank_sender_name' => null,
                'bank_reference' => null,
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            return $booking;
        });

        $request->session()->forget(self::CHECKOUT_SESSION_KEY);

        return redirect(route('bookings.mine'))->with('success', 'Payment completed. Your booking is confirmed.');
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $rules = [
            'status' => ['required', Rule::in(['confirmed', 'cancelled', 'checked_in', 'checked_out'])],
        ];

        if ($request->has('room_id')) {
            $rules += [
                'user_id' => ['nullable', 'exists:users,id'],
                'guest_name' => ['nullable', 'string', 'max:255'],
                'guest_email' => ['nullable', 'email', 'max:255'],
                'room_id' => ['required', 'exists:rooms,id'],
                'check_in' => ['required', 'date'],
                'check_out' => ['required', 'date', 'after:check_in'],
                'adults' => ['required', 'integer', 'min:1'],
                'children' => ['required', 'integer', 'min:0'],
                'special_request' => ['nullable', 'string', 'max:1000'],
            ];
        }

        $validated = $request->validate($rules);

        if ($request->has('room_id')) {
            if (empty($validated['user_id']) && (empty($validated['guest_name']) || empty($validated['guest_email']))) {
                throw ValidationException::withMessages([
                    'guest_name' => 'Choose a user or enter guest name and email.',
                ]);
            }

            $room = Room::with('roomType')->findOrFail($validated['room_id']);
            $this->ensureRoomIsAvailable($room, $validated['check_in'], $validated['check_out'], $booking);

            $nights = $this->calculateNights($validated['check_in'], $validated['check_out']);
            $validated['total_price'] = $nights * $room->roomType->price_per_night;
        }

        $booking->update($validated);

        return back()->with('success', 'Booking status updated successfully.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return back()->with('success', 'Booking deleted successfully.');
    }

    private function ensureRoomIsAvailable(Room $room, string $checkIn, string $checkOut, ?Booking $ignoreBooking = null): void
    {
        $checkIn = Carbon::parse($checkIn)->startOfDay()->toDateString();
        $checkOut = Carbon::parse($checkOut)->startOfDay()->toDateString();

        $overlapExists = $room->bookings()
            ->blockingAvailability()
            ->when($ignoreBooking, fn ($query) => $query->whereKeyNot($ignoreBooking->id))
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn)
            ->exists();

        if ($overlapExists) {
            throw ValidationException::withMessages([
                'room_id' => 'This room is not available for the selected dates.',
            ]);
        }
    }

    private function calculateNights(string $checkIn, string $checkOut): int
    {
        $nights = Carbon::parse($checkIn)
            ->startOfDay()
            ->diffInDays(Carbon::parse($checkOut)->startOfDay());

        if ($nights < 1) {
            throw ValidationException::withMessages([
                'check_out' => 'Check-out date must be at least one day after check-in date.',
            ]);
        }

        return $nights;
    }

}
