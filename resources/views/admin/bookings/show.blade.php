@extends('layouts.admin')

@section('title', 'Booking #' . $booking->id)
@section('page_title', 'Booking Details')

@section('content')
@php
    $nights = $booking->check_in && $booking->check_out ? $booking->check_in->diffInDays($booking->check_out) : 0;
    $guestName = $booking->user->name ?? $booking->guest_name ?? 'Guest';
    $guestEmail = $booking->user->email ?? $booking->guest_email ?? 'No email';
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="mb-1 text-sm font-semibold uppercase text-slate-400">Booking #{{ $booking->id }}</p>
            <h1 class="mb-0 text-2xl font-bold text-slate-700 sm:text-3xl">{{ $guestName }}</h1>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.bookings.edit', $booking) }}" class="rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 px-4 py-2 text-xs font-bold uppercase text-white shadow-soft-md">Edit</a>
            <a href="{{ route('admin.bookings.index') }}" class="rounded-lg bg-slate-100 px-4 py-2 text-xs font-bold uppercase text-slate-700">Back</a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="rounded-2xl bg-white p-6 shadow-soft-xl xl:col-span-2">
            <h6 class="mb-4 text-slate-700">Reservation</h6>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div><p class="mb-1 text-xs font-bold uppercase text-slate-400">Guest</p><p class="mb-0 font-semibold text-slate-700">{{ $guestName }}</p><p class="mb-0 text-sm text-slate-400">{{ $guestEmail }}</p></div>
                <div><p class="mb-1 text-xs font-bold uppercase text-slate-400">Room</p><p class="mb-0 font-semibold text-slate-700">Room {{ $booking->room->room_number ?? 'N/A' }}</p><p class="mb-0 text-sm text-slate-400">{{ $booking->room->roomType->name ?? 'Room type unavailable' }}</p></div>
                <div><p class="mb-1 text-xs font-bold uppercase text-slate-400">Dates</p><p class="mb-0 font-semibold text-slate-700">{{ optional($booking->check_in)->format('M d, Y') }} to {{ optional($booking->check_out)->format('M d, Y') }}</p><p class="mb-0 text-sm text-slate-400">{{ $nights }} {{ Str::plural('night', $nights) }}</p></div>
                <div><p class="mb-1 text-xs font-bold uppercase text-slate-400">Guests</p><p class="mb-0 font-semibold text-slate-700">{{ $booking->adults }} adult{{ $booking->adults === 1 ? '' : 's' }}, {{ $booking->children }} child{{ $booking->children === 1 ? '' : 'ren' }}</p></div>
                <div><p class="mb-1 text-xs font-bold uppercase text-slate-400">Status</p><p class="mb-0 font-semibold capitalize text-slate-700">{{ str_replace('_', ' ', $booking->status) }}</p></div>
                <div><p class="mb-1 text-xs font-bold uppercase text-slate-400">Total</p><p class="mb-0 font-semibold text-slate-700">${{ number_format($booking->total_price ?? 0, 2) }}</p></div>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-soft-xl">
            <h6 class="mb-4 text-slate-700">Payment</h6>
            @if($booking->payment)
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between"><span>Status</span><strong class="capitalize">{{ $booking->payment->status }}</strong></div>
                    <div class="flex justify-between"><span>Method</span><strong class="capitalize">{{ str_replace('_', ' ', $booking->payment->method) }}</strong></div>
                    <div class="flex justify-between"><span>Amount</span><strong>${{ number_format($booking->payment->amount, 2) }}</strong></div>
                    @if($booking->payment->method === 'bank_transfer')
                        <div class="flex justify-between"><span>Bank</span><strong>{{ $booking->payment->bankTransfer->bank_name ?? 'N/A' }}</strong></div>
                        <div class="flex justify-between"><span>Sender</span><strong>{{ $booking->payment->bank_sender_name ?? 'N/A' }}</strong></div>
                        <div class="flex justify-between"><span>Reference</span><strong>{{ $booking->payment->bank_reference ?? 'N/A' }}</strong></div>
                    @endif
                    <div class="flex justify-between"><span>Paid at</span><strong>{{ optional($booking->payment->paid_at)->format('M d, Y H:i') ?? 'N/A' }}</strong></div>
                    @if($booking->payment->receipt_path)
                        <div class="flex justify-between">
                            <span>Receipt</span>
                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($booking->payment->receipt_path) }}" target="_blank" class="font-bold text-blue-600">View</a>
                        </div>
                    @endif
                </div>
            @else
                <p class="mb-0 text-sm text-slate-400">No payment has been recorded yet.</p>
            @endif
        </div>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-soft-xl">
        <h6 class="mb-3 text-slate-700">Special request</h6>
        <p class="mb-0 text-sm text-slate-500">{{ $booking->special_request ?: 'No special request.' }}</p>
    </div>
</div>
@endsection
