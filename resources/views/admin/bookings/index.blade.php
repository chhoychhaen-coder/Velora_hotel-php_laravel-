@extends('layouts.admin')

@section('title', 'Bookings')
@section('page_title', 'Bookings')

@section('content')
@php
    $statusStyles = [
        'confirmed' => 'bg-blue-100 text-blue-800',
        'cancelled' => 'bg-red-100 text-red-800',
        'checked_in' => 'bg-green-100 text-green-800',
        'checked_out' => 'bg-gray-100 text-gray-800',
    ];
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="mb-1 text-sm font-semibold uppercase text-slate-400">Reservations</p>
            <h1 class="mb-0 text-2xl font-bold text-slate-700 sm:text-3xl">Bookings</h1>
        </div>

        <a href="{{ route('admin.bookings.create') }}"
           class="inline-flex items-center justify-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 px-4 py-2.5 text-sm font-bold uppercase text-white shadow-soft-md transition hover:scale-102 sm:w-auto">
            Create Booking
        </a>
    </div>

    <form method="GET"
          action="{{ route('admin.bookings.index') }}"
          class="rounded-2xl bg-white p-4 shadow-soft-xl">
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-[1fr_1fr_1fr_auto] lg:items-end">
            <div>
                <label class="mb-2 block text-xs font-bold uppercase text-slate-400">Status</label>
                <select name="status" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All statuses</option>
                    @foreach(['confirmed','cancelled','checked_in','checked_out'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-xs font-bold uppercase text-slate-400">Check-in from</label>
                <input type="date"
                       name="date_from"
                       value="{{ request('date_from') }}"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="mb-2 block text-xs font-bold uppercase text-slate-400">Check-out to</label>
                <input type="date"
                       name="date_to"
                       value="{{ request('date_to') }}"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        class="inline-flex min-h-10 flex-1 items-center justify-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 px-4 py-2 text-xs font-bold uppercase text-white shadow-soft-md transition hover:scale-102 lg:flex-none">
                    Filter
                </button>
                <a href="{{ route('admin.bookings.index') }}"
                   class="inline-flex min-h-10 flex-1 items-center justify-center rounded-lg bg-slate-100 px-4 py-2 text-xs font-bold uppercase text-slate-700 transition hover:bg-slate-200 lg:flex-none">
                    Clear
                </a>
            </div>
        </div>
    </form>

    <div class="relative flex min-w-0 flex-col break-words rounded-2xl border-0 bg-white shadow-soft-xl">
        <div class="border-b border-gray-100 p-6">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h6 class="mb-0 text-slate-700">Booking list</h6>
                    <p class="mb-0 text-sm leading-normal text-slate-400">
                        {{ $bookings->total() }} {{ Str::plural('booking', $bookings->total()) }} found
                    </p>
                </div>
                <span class="text-xs font-semibold uppercase text-slate-400">
                    Page {{ $bookings->currentPage() }} of {{ $bookings->lastPage() }}
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[1120px] items-center border-gray-200 text-slate-500">
                <thead class="align-bottom">
                    <tr>
                        <th class="border-b border-gray-200 bg-transparent px-6 py-3 text-left text-xxs font-bold uppercase text-slate-400 opacity-70">ID</th>
                        <th class="border-b border-gray-200 bg-transparent px-6 py-3 text-left text-xxs font-bold uppercase text-slate-400 opacity-70">Guest</th>
                        <th class="border-b border-gray-200 bg-transparent px-6 py-3 text-left text-xxs font-bold uppercase text-slate-400 opacity-70">Room</th>
                        <th class="border-b border-gray-200 bg-transparent px-6 py-3 text-left text-xxs font-bold uppercase text-slate-400 opacity-70">Dates</th>
                        <th class="border-b border-gray-200 bg-transparent px-6 py-3 text-left text-xxs font-bold uppercase text-slate-400 opacity-70">Guests</th>
                        <th class="border-b border-gray-200 bg-transparent px-6 py-3 text-right text-xxs font-bold uppercase text-slate-400 opacity-70">Total</th>
                        <th class="border-b border-gray-200 bg-transparent px-6 py-3 text-center text-xxs font-bold uppercase text-slate-400 opacity-70">Status</th>
                        <th class="border-b border-gray-200 bg-transparent px-6 py-3 text-right text-xxs font-bold uppercase text-slate-400 opacity-70">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($bookings as $booking)
                        @php
                            $guestName = $booking->user->name ?? $booking->guest_name ?? 'Guest';
                            $guestEmail = $booking->user->email ?? $booking->guest_email ?? 'No email';
                            $status = $booking->status;
                        @endphp

                        <tr>
                            <td class="border-b bg-transparent p-4 align-middle">
                                <span class="text-sm font-semibold text-slate-700">#{{ $booking->id }}</span>
                            </td>

                            <td class="border-b bg-transparent p-4 align-middle">
                                <div class="min-w-0">
                                    <p class="mb-0 max-w-[190px] truncate text-sm font-semibold text-slate-700">{{ $guestName }}</p>
                                    <p class="mb-0 max-w-[190px] truncate text-xs leading-tight text-slate-400">{{ $guestEmail }}</p>
                                </div>
                            </td>

                            <td class="border-b bg-transparent p-4 align-middle">
                                <p class="mb-0 text-sm font-semibold text-slate-700">Room {{ $booking->room->room_number ?? 'N/A' }}</p>
                                <p class="mb-0 text-xs leading-tight text-slate-400">{{ $booking->room->roomType->name ?? 'Room type unavailable' }}</p>
                            </td>

                            <td class="border-b bg-transparent p-4 align-middle">
                                <p class="mb-0 whitespace-nowrap text-sm font-semibold text-slate-700">
                                    {{ optional($booking->check_in)->format('M d, Y') ?? 'N/A' }}
                                </p>
                                <p class="mb-0 whitespace-nowrap text-xs leading-tight text-slate-400">
                                    to {{ optional($booking->check_out)->format('M d, Y') ?? 'N/A' }}
                                </p>
                            </td>

                            <td class="border-b bg-transparent p-4 align-middle">
                                <span class="whitespace-nowrap text-sm text-slate-700">
                                    {{ $booking->adults }} adult{{ $booking->adults === 1 ? '' : 's' }},
                                    {{ $booking->children }} child{{ $booking->children === 1 ? '' : 'ren' }}
                                </span>
                            </td>

                            <td class="border-b bg-transparent p-4 text-right align-middle">
                                <span class="whitespace-nowrap text-sm font-semibold text-slate-700">${{ number_format($booking->total_price ?? 0, 2) }}</span>
                            </td>

                            <td class="border-b bg-transparent p-4 text-center align-middle">
                                <span class="{{ $statusStyles[$status] ?? 'bg-gray-100 text-gray-800' }} inline-flex rounded-lg px-2.5 py-1 text-xs font-bold uppercase leading-none">
                                    {{ str_replace('_', ' ', $status) }}
                                </span>
                            </td>

                            <td class="border-b bg-transparent p-4 align-middle">
                                <div class="ml-auto flex w-max items-center justify-end gap-2">
                                    <a href="{{ route('admin.bookings.show', $booking) }}"
                                       class="inline-flex h-9 items-center justify-center rounded-lg bg-slate-100 px-3 text-xs font-bold uppercase text-slate-700 transition hover:bg-slate-200">
                                        View
                                    </a>

                                  

                                    <form method="POST"
                                          action="{{ route('admin.bookings.update', $booking) }}"
                                          class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')

                                        <select name="status"
                                                aria-label="Update booking status"
                                                class="h-9 w-36 rounded-lg border border-gray-300 px-2 text-xs text-slate-700 focus:border-blue-500 focus:ring-blue-500">
                                            @foreach(['confirmed','cancelled','checked_in','checked_out'] as $option)
                                                <option value="{{ $option }}" @selected($booking->status === $option)>
                                                    {{ ucfirst(str_replace('_',' ', $option)) }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <button type="submit"
                                                class="inline-flex h-9 items-center justify-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 px-3 text-xs font-bold uppercase text-white shadow-soft-md transition hover:scale-102">
                                            Update
                                        </button>
                                    </form>

                                    <form method="POST"
                                          action="{{ route('admin.bookings.destroy', $booking) }}"
                                          onsubmit="return confirm('Delete this booking?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="inline-flex h-9 items-center justify-center rounded-lg bg-gradient-to-tl from-red-600 to-rose-400 px-3 text-xs font-bold uppercase text-white shadow-soft-md transition hover:scale-102">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-sm text-slate-400">
                                No bookings found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($bookings->hasPages())
        <div class="flex justify-end">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection
