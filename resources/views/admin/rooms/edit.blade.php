@extends('layouts.admin')

@section('title', 'Edit Room')
@section('page_title', 'Edit Room')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Room</h1>

        <a href="{{ route('admin.rooms.index') }}"
           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.rooms.update', $room) }}" method="POST" class="space-y-5">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-medium text-gray-700">Room Number</label>
                <input type="text" name="room_number"
                       value="{{ old('room_number', $room->room_number) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                       placeholder="e.g. A101">
                @error('room_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Room Type</label>
                <select name="room_type_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Select Room Type</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}" @selected((int) old('room_type_id', $room->room_type_id) === $type->id)>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                @error('room_type_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Floor</label>
                <input type="number" name="floor"
                       value="{{ old('floor', $room->floor) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                       placeholder="e.g. 1">
                @error('floor')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @foreach(['available' => 'Available', 'occupied' => 'Occupied', 'maintenance' => 'Maintenance'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $room->status) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea name="notes" rows="4"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                          placeholder="Optional notes...">{{ old('notes', $room->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded">
                    Update Room
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
