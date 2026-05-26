@extends('layouts.admin')

@section('title', 'Booked Rooms')
@section('page_title', 'Booked Rooms')

@section('content')
@php
    $statusStyles = [
        'confirmed' => 'bg-blue-100 text-blue-800',
        'checked_in' => 'bg-green-100 text-green-800',
        'checked_out' => 'bg-slate-100 text-slate-700',
    ];
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="mb-1 text-sm font-semibold uppercase text-slate-400">Room occupancy</p>
            <h1 class="mb-0 text-2xl font-bold text-slate-700 sm:text-3xl">Booked Rooms</h1>
            <p class="mb-0 text-sm text-slate-400">
                {{ $selectedDate ? 'Rooms booked on ' . \Illuminate\Support\Carbon::parse($selectedDate)->format('M d, Y') : 'Upcoming and active room bookings' }}
            </p>
        </div>

        <form method="GET" action="{{ route('admin.booked-rooms') }}" class="grid grid-cols-1 gap-2 rounded-2xl bg-white p-3 shadow-soft-xl sm:grid-cols-[1fr_1fr_auto]">
            <select name="status" class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700">
                <option value="">All active statuses</option>
                @foreach(['confirmed', 'checked_in', 'checked_out'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </option>
                @endforeach
            </select>
            <input type="date" name="date" value="{{ $selectedDate }}" class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700">
            <button type="submit" class="rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 px-4 py-2 text-xs font-bold uppercase text-white shadow-soft-md">
                Show
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        @forelse($bookings as $booking)
            @php
                $guestName = $booking->user->name ?? $booking->guest_name ?? 'Guest';
                $guestEmail = $booking->user->email ?? $booking->guest_email ?? 'No email';
                $nights = $booking->check_in && $booking->check_out ? $booking->check_in->diffInDays($booking->check_out) : 0;
                $paymentStatus = 'paid';
                $hasOverlap = $overlapIds->contains($booking->id);
            @endphp

            <div class="relative overflow-hidden rounded-2xl bg-white shadow-soft-xl {{ $hasOverlap ? 'ring-2 ring-red-400' : '' }}">
                <div class="bg-gradient-to-tl from-slate-900 to-slate-700 p-5 text-white">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="mb-1 text-xs font-bold uppercase opacity-70">{{ $booking->room->roomType->name ?? 'Room type unavailable' }}</p>
                            <h3 class="mb-0 text-2xl font-bold text-white">Room {{ $booking->room->room_number ?? 'N/A' }}</h3>
                        </div>
                        <span class="{{ $statusStyles[$booking->status] ?? 'bg-gray-100 text-gray-800' }} rounded-lg px-2.5 py-1 text-xs font-bold uppercase">
                            {{ str_replace('_', ' ', $booking->status) }}
                        </span>
                    </div>
                </div>

                <div class="space-y-4 p-5">
                    @if($hasOverlap)
                        <div class="rounded-xl bg-red-100 p-3 text-sm font-semibold text-red-800">
                            This room has another active booking during these dates.
                        </div>
                    @endif

                    <div>
                        <p class="mb-1 text-xs font-bold uppercase text-slate-400">Guest</p>
                        <p class="mb-0 truncate font-semibold text-slate-700">{{ $guestName }}</p>
                        <p class="mb-0 truncate text-sm text-slate-400">{{ $guestEmail }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-xl bg-slate-50 p-3">
                            <p class="mb-1 text-xs font-bold uppercase text-slate-400">Check in</p>
                            <p class="mb-0 text-sm font-semibold text-slate-700">{{ optional($booking->check_in)->format('M d, Y') }}</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 p-3">
                            <p class="mb-1 text-xs font-bold uppercase text-slate-400">Check out</p>
                            <p class="mb-0 text-sm font-semibold text-slate-700">{{ optional($booking->check_out)->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3 text-sm">
                        <div>
                            <p class="mb-1 text-xs font-bold uppercase text-slate-400">Nights</p>
                            <p class="mb-0 font-semibold text-slate-700">{{ $nights }}</p>
                        </div>
                        <div>
                            <p class="mb-1 text-xs font-bold uppercase text-slate-400">Guests</p>
                            <p class="mb-0 font-semibold text-slate-700">{{ $booking->adults + $booking->children }}</p>
                        </div>
                        <div>
                            <p class="mb-1 text-xs font-bold uppercase text-slate-400">Payment</p>
                            <p class="mb-0 font-semibold capitalize text-slate-700">{{ $paymentStatus }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                        <strong class="text-slate-700">${{ number_format($booking->total_price ?? 0, 2) }}</strong>
                        <div class="flex gap-2">

                            <a href="{{ route('admin.bookings.show', $booking) }}" class="rounded-lg bg-slate-100 px-3 py-2 text-xs font-bold uppercase text-slate-700 transition hover:bg-slate-200">
                                Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-2xl bg-white p-8 text-center text-sm text-slate-400 shadow-soft-xl xl:col-span-3">
                No booked rooms found.
            </div>
        @endforelse
    </div>

    @if($bookings->hasPages())
        <div class="flex justify-end">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection
