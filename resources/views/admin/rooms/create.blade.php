@extends('layouts.admin')

@section('title', 'Create Room')
@section('page_title', 'Create Room')

@section('content')
<div class="container mx-auto px-4 py-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Create Room</h1>

        <a href="{{ route('admin.rooms.index') }}"
           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">

        <form action="{{ route('admin.rooms.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Room Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Room Number</label>
                <input type="text" name="room_number"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                       placeholder="e.g. A101">
            </div>

            <!-- Room Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Room Type</label>
                <select name="room_type_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Select Room Type</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Floor -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Floor</label>
                <input type="number" name="floor"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                       placeholder="e.g. 1">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="available">Available</option>
                    <option value="occupied">Occupied</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea name="notes" rows="4"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                          placeholder="Optional notes..."></textarea>
            </div>

            <!-- Submit -->
            <div class="pt-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded">
                    Create Room
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
