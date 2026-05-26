@extends('layouts.admin')

@section('title', 'Create Booking')
@section('page_title', 'Create Booking')

@section('content')
<div class="container mx-auto px-4 py-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Create Booking</h1>

        <a href="{{ route('admin.bookings.index') }}"
           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">

        {{-- ERROR DISPLAY --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.bookings.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- User -->
            <div>
                <label class="block text-sm font-medium text-gray-700">User</label>
                <select name="user_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                            @selected(old('user_id') == $user->id)>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Room -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Room</label>
                <select name="room_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Select Room</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}"
                            @selected(old('room_id') == $room->id)>
                            {{ $room->room_number }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700">Check In</label>
                    <input type="date" name="check_in"
                           value="{{ old('check_in') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Check Out</label>
                    <input type="date" name="check_out"
                           value="{{ old('check_out') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

            </div>

            <!-- Guests -->
            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700">Adults</label>
                    <input type="number" name="adults" min="1"
                           value="{{ old('adults', 1) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Children</label>
                    <input type="number" name="children" min="0"
                           value="{{ old('children', 0) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">

                    @foreach (['confirmed'] as $status)
                        <option value="{{ $status }}"
                            @selected(old('status') == $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach

                </select>
            </div>

            <!-- Submit -->
            <div class="pt-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded">
                    Create Booking
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
