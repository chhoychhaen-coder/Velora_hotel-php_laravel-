<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = today();

        $stats = [
            'bookings' => Booking::paid()->count(),
            'pending_bookings' => 0,
            'today_arrivals' => Booking::whereDate('check_in', $today)
                ->paid()
                ->whereIn('status', ['confirmed'])
                ->count(),
            'today_checkouts' => Booking::whereDate('check_out', $today)
                ->paid()
                ->whereIn('status', ['confirmed', 'checked_in'])
                ->count(),
            'overdue_payments' => 0,
            'occupied_rooms' => Room::where('status', 'occupied')->count(),
            'available_rooms' => Room::where('status', 'available')->count(),
            'maintenance_rooms' => Room::where('status', 'maintenance')->count(),
            'revenue' => Payment::where('status', 'paid')->sum('amount'),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'users' => User::count(),
        ];

        return view('dashboard', [
            'stats' => $stats,
            'recentBookings' => Booking::with(['user', 'room'])->paid()->latest('created_at')->limit(5)->get(),
            'roomStatus' => Room::query()
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray(),
            'recentPayments' => Payment::where('status', 'paid')->latest('id')->limit(5)->get(),
            'messages' => ContactMessage::where('is_read', false)->latest('id')->limit(5)->get(),
        ]);
    }

    public function updateBankTransfer(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bank_transfer_id' => ['nullable', 'exists:bank_transfers,id'],
            'bank_name' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'],
            'qr_code' => ['nullable', 'image', 'max:2048'],
        ]);

        $bankTransfer = isset($validated['bank_transfer_id'])
            ? BankTransfer::findOrFail($validated['bank_transfer_id'])
            : new BankTransfer();

        if ($request->hasFile('qr_code')) {
            if ($bankTransfer->qr_code_path) {
                Storage::disk('public')->delete($bankTransfer->qr_code_path);
            }

            $validated['qr_code_path'] = $request->file('qr_code')->store('payment-qr-codes', 'public');
        }

        unset($validated['qr_code']);
        unset($validated['bank_transfer_id']);
        $bankTransfer->fill($validated)->save();

        return back()->with('success', 'Bank transfer method saved successfully.');
    }

    public function destroyBankTransfer(BankTransfer $bankTransfer): RedirectResponse
    {
        if ($bankTransfer->qr_code_path) {
            Storage::disk('public')->delete($bankTransfer->qr_code_path);
        }

        $bankTransfer->delete();

        return back()->with('success', 'Bank transfer method deleted successfully.');
    }

    public function calendar(Request $request): View
    {
        $startParameter = $request->query('start');
        $start = is_string($startParameter) && $startParameter !== ''
            ? Carbon::parse($startParameter)->startOfDay()
            : today();
        $days = collect(range(0, 13))->map(fn(int $offset) => $start->copy()->addDays($offset));

        $rooms = Room::with(['roomType', 'bookings' => function ($query) use ($start): void {
            $query->with(['user', 'payment'])
                ->paid()
                ->where('status', '!=', 'cancelled')
                ->whereDate('check_out', '>=', $start)
                ->whereDate('check_in', '<=', $start->copy()->addDays(13));
        }])
            ->orderBy('room_number')
            ->get();

        return view('admin.calendar.index', [
            'days' => $days,
            'rooms' => $rooms,
            'start' => $start,
        ]);
    }

    public function bookedRooms(Request $request): View
    {
        $status = $request->query('status');
        $status = is_string($status) ? $status : null;
        $dateParameter = $request->query('date');
        $date = is_string($dateParameter) && $dateParameter !== ''
            ? Carbon::parse($dateParameter)->toDateString()
            : null;
        $overlapIds = collect();

        $bookings = Booking::with(['user', 'room.roomType', 'payment'])
            ->paid()
            ->where('status', '!=', 'cancelled')
            ->when($status, fn($query) => $query->where('status', $status))
            ->when($date, function ($query) use ($date): void {
                $query->whereDate('check_in', '<=', $date)
                    ->whereDate('check_out', '>', $date);
            }, function ($query): void {
                $query->whereDate('check_out', '>=', today());
            })
            ->orderBy('check_in')
            ->paginate(12)
            ->withQueryString();

        return view('admin.booked-rooms.index', [
            'bookings' => $bookings,
            'selectedDate' => $date,
            'overlapIds' => $overlapIds,
        ]);
    }



    public function reports(Request $request): View
    {
        $fromParameter = $request->query('from');
        $from = is_string($fromParameter) && $fromParameter !== ''
            ? Carbon::parse($fromParameter)->startOfDay()
            : now()->subMonths(5)->startOfMonth();

        $toParameter = $request->query('to');
        $to = is_string($toParameter) && $toParameter !== ''
            ? Carbon::parse($toParameter)->endOfDay()
            : now()->endOfDay();

        $bookingsInRange = Booking::paid()->whereBetween('created_at', [$from, $to]);

        return view('admin.reports.index', [
            'from' => $from,
            'to' => $to,
            'totals' => [
                'revenue' => Payment::where('status', 'paid')->whereBetween('paid_at', [$from, $to])->sum('amount'),
                'bookings' => (clone $bookingsInRange)->count(),
                'cancelled' => (clone $bookingsInRange)->where('status', 'cancelled')->count(),
                'occupancy' => Room::count() > 0
                    ? round((Room::where('status', 'occupied')->count() / Room::count()) * 100, 1)
                    : 0,
            ],
            'monthlyRevenue' => Payment::query()
                ->where('status', 'paid')
                ->whereBetween('paid_at', [$from, $to])
                ->orderBy('paid_at')
                ->get()
                ->groupBy(fn(Payment $payment) => optional($payment->paid_at)->format('Y-m'))
                ->map(fn($payments, $month) => (object) [
                    'month' => $month ?: 'Unknown',
                    'total' => $payments->sum('amount'),
                ])
                ->values(),
            'roomTypeBookings' => Booking::query()
                ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
                ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
                ->join('payments', 'bookings.id', '=', 'payments.booking_id')
                ->select('room_types.name', DB::raw('COUNT(*) as total'))
                ->whereBetween('bookings.created_at', [$from, $to])
                ->where('payments.status', 'paid')
                ->groupBy('room_types.name')
                ->orderByDesc('total')
                ->limit(8)
                ->get(),
            'paymentMethods' => Payment::query()
                ->select('method', DB::raw('COUNT(*) as total'), DB::raw('SUM(amount) as amount'))
                ->whereBetween('paid_at', [$from, $to])
                ->groupBy('method')
                ->orderByDesc('amount')
                ->get(),
            'statusBreakdown' => Booking::query()
                ->select('status', DB::raw('COUNT(*) as total'))
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('status')
                ->get(),
        ]);
    }
}
