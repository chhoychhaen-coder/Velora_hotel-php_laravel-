<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        return view('admin.payments.index', [
            'payments' => Payment::with(['booking.user', 'bankTransfer'])
                ->where('status', 'paid')
                ->latest('id')
                ->paginate(10),
        ]);
    }
public function create(): View
{
    return view('admin.payments.create', [
        'bookings' => Booking::paid()->with('user')->get(),
        'paymentMethods' => collect(Payment::METHODS)->except('bank_transfer')->all(),
    ]);
}
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'booking_id' => ['required', 'exists:bookings,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'method' => ['required', Rule::in(array_keys(Payment::METHODS))],
            'transaction_id' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['paid'])],
            'paid_at' => ['nullable', 'date'],
        ]);

        Payment::create([
            'booking_id' => $request->booking_id,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'method' => $request->method,
            'transaction_id' => $request->transaction_id,
            'status' => $request->status,
            'paid_at' => $request->paid_at ?: now(),
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Payment created successfully.');
    }

    public function update(Request $request, Payment $payment): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['paid'])],
            'paid_at' => ['nullable', 'date'],
        ]);

        if ($validated['status'] === 'paid' && empty($validated['paid_at'])) {
            $validated['paid_at'] = now();
        }

        if ($validated['status'] !== 'paid' && empty($validated['paid_at'])) {
            $validated['paid_at'] = null;
        }

        $payment->update($validated);

        if ($payment->status === 'paid') {
            $payment->booking()->update(['status' => 'confirmed']);
        }

        return back()->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        $payment->delete();

        return back()->with('success', 'Payment deleted successfully.');
    }
}
