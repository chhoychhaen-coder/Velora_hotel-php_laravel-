@extends('layouts.admin')

@section('title', 'Room Calendar')
@section('page_title', 'Room Calendar')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="mb-1 text-sm font-semibold uppercase text-slate-400">Availability</p>
            <h1 class="mb-0 text-2xl font-bold text-slate-700 sm:text-3xl">Room Calendar</h1>
        </div>

        <form method="GET" action="{{ route('admin.calendar') }}" class="flex flex-col gap-2 sm:flex-row">
            <input type="date" name="start" value="{{ $start->format('Y-m-d') }}" class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700">
            <button class="rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 px-4 py-2 text-xs font-bold uppercase text-white shadow-soft-md" type="submit">
                View
            </button>
        </form>
    </div>

    <div class="rounded-2xl bg-white p-4 shadow-soft-xl">
        <div class="mb-4 flex flex-wrap gap-3 text-xs font-semibold text-slate-500">
            <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded bg-emerald-100"></span>Available</span>
            <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded bg-blue-100"></span>Booked</span>
            <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded bg-yellow-100"></span>Maintenance</span>
            <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded bg-slate-100"></span>Occupied status</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[1100px] border-separate border-spacing-0 text-sm">
                <thead>
                    <tr>
                        <th class="sticky left-0 z-10 border-b border-gray-200 bg-white px-4 py-3 text-left text-xs font-bold uppercase text-slate-400">Room</th>
                        @foreach($days as $day)
                            <th class="border-b border-gray-200 px-3 py-3 text-center text-xs font-bold uppercase text-slate-400">
                                <span class="block">{{ $day->format('D') }}</span>
                                <span class="block text-slate-700">{{ $day->format('M d') }}</span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                        <tr>
                            <td class="sticky left-0 z-10 border-b border-gray-100 bg-white px-4 py-3">
                                <p class="mb-0 font-semibold text-slate-700">Room {{ $room->room_number }}</p>
                                <p class="mb-0 text-xs text-slate-400">{{ $room->roomType->name ?? 'No type' }}</p>
                            </td>
                            @foreach($days as $day)
                                @php
                                    $booking = $room->bookings->first(function ($booking) use ($day) {
                                        return $booking->check_in->lte($day) && $booking->check_out->gt($day);
                                    });
                                    $isMaintenance = $room->status === 'maintenance';
                                    $isOccupied = $room->status === 'occupied' && ! $booking;
                                @endphp
                                <td class="border-b border-gray-100 px-2 py-3 text-center align-top">
                                    @if($booking)
                                        <a href="{{ route('admin.bookings.show', $booking) }}" class="block rounded-lg bg-blue-100 px-2 py-2 text-left text-xs text-blue-800">
                                            <span class="block truncate font-bold">{{ $booking->user->name ?? $booking->guest_name ?? 'Guest' }}</span>
                                            <span class="block truncate">{{ str_replace('_', ' ', $booking->status) }}</span>
                                        </a>
                                    @elseif($isMaintenance)
                                        <span class="block rounded-lg bg-yellow-100 px-2 py-2 text-xs font-bold uppercase text-yellow-800">Maintenance</span>
                                    @elseif($isOccupied)
                                        <span class="block rounded-lg bg-slate-100 px-2 py-2 text-xs font-bold uppercase text-slate-600">Occupied</span>
                                    @else
                                        <span class="block rounded-lg bg-emerald-100 px-2 py-2 text-xs font-bold uppercase text-emerald-700">Open</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $days->count() + 1 }}" class="p-8 text-center text-slate-400">No rooms found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
