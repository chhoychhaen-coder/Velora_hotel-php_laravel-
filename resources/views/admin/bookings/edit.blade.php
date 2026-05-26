@extends('layouts.admin')

@section('title', 'Edit Booking')
@section('page_title', 'Edit Booking')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="mb-1 text-sm font-semibold uppercase text-slate-400">Booking #{{ $booking->id }}</p>
            <h1 class="mb-0 text-2xl font-bold text-slate-700 sm:text-3xl">Edit Booking</h1>
        </div>
        <a href="{{ route('admin.bookings.show', $booking) }}" class="rounded-lg bg-slate-100 px-4 py-2 text-xs font-bold uppercase text-slate-700">Details</a>
    </div>

    @if ($errors->any())
        <div class="rounded-lg bg-red-100 p-4 text-sm text-red-800">
            <ul class="ml-5 list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="rounded-2xl bg-white p-6 shadow-soft-xl">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
            <div>
                <label class="mb-2 block text-xs font-bold uppercase text-slate-400">Registered user</label>
                <select name="user_id" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700">
                    <option value="">Guest booking</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id', $booking->user_id) == $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-xs font-bold uppercase text-slate-400">Room</label>
                <select name="room_id" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700" required>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" @selected(old('room_id', $booking->room_id) == $room->id)>
                            Room {{ $room->room_number }} - {{ $room->roomType->name ?? 'No type' }} (${{ number_format($room->roomType->price_per_night ?? 0, 2) }}/night)
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-xs font-bold uppercase text-slate-400">Guest name</label>
                <input type="text" name="guest_name" value="{{ old('guest_name', $booking->guest_name) }}" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700">
            </div>

            <div>
                <label class="mb-2 block text-xs font-bold uppercase text-slate-400">Guest email</label>
                <input type="email" name="guest_email" value="{{ old('guest_email', $booking->guest_email) }}" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700">
            </div>

            <div>
                <label class="mb-2 block text-xs font-bold uppercase text-slate-400">Check in</label>
                <input type="date" name="check_in" value="{{ old('check_in', optional($booking->check_in)->format('Y-m-d')) }}" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700" required>
            </div>

            <div>
                <label class="mb-2 block text-xs font-bold uppercase text-slate-400">Check out</label>
                <input type="date" name="check_out" value="{{ old('check_out', optional($booking->check_out)->format('Y-m-d')) }}" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700" required>
            </div>

            <div>
                <label class="mb-2 block text-xs font-bold uppercase text-slate-400">Adults</label>
                <input type="number" min="1" name="adults" value="{{ old('adults', $booking->adults) }}" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700" required>
            </div>

            <div>
                <label class="mb-2 block text-xs font-bold uppercase text-slate-400">Children</label>
                <input type="number" min="0" name="children" value="{{ old('children', $booking->children) }}" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700" required>
            </div>

            <div>
                <label class="mb-2 block text-xs font-bold uppercase text-slate-400">Status</label>
                <select name="status" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700" required>
                    @foreach(['confirmed','cancelled','checked_in','checked_out'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $booking->status) === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="lg:col-span-2">
                <label class="mb-2 block text-xs font-bold uppercase text-slate-400">Special request</label>
                <textarea name="special_request" rows="4" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700">{{ old('special_request', $booking->special_request) }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <a href="{{ route('admin.bookings.index') }}" class="rounded-lg bg-slate-100 px-4 py-2 text-xs font-bold uppercase text-slate-700">Cancel</a>
            <button type="submit" class="rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 px-4 py-2 text-xs font-bold uppercase text-white shadow-soft-md">Save Booking</button>
        </div>
    </form>
</div>
@endsection
