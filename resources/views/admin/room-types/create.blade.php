@extends('layouts.admin')

@section('title', 'Create Room Type')
@section('page_title', 'Create Room Type')

@section('content')
<div class="container mx-auto px-4 py-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Create Room Type</h1>

        <a href="{{ route('admin.room-types.index') }}"
           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">

        <form action="{{ route('admin.room-types.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name"
                       value="{{ old('name') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                       placeholder="e.g. Deluxe Room">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="4"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                          placeholder="Room type description...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Capacity Adults -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Capacity Adults</label>
                <input type="number" name="capacity_adults" min="1"
                       value="{{ old('capacity_adults') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('capacity_adults')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Capacity Children -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Capacity Children</label>
                <input type="number" name="capacity_children" min="0"
                       value="{{ old('capacity_children') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('capacity_children')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Price Per Night ($)</label>
                <input type="number" step="0.01" name="price_per_night"
                       value="{{ old('price_per_night') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('price_per_night')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Room Type Image</label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                       class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="mt-1 text-xs text-gray-500">Upload JPG, PNG, or WEBP. Max 2 MB.</p>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active -->
            <div class="flex items-center">
                <input type="checkbox" name="is_active" value="1"
                       @checked(old('is_active', true))
                       class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                <label class="ml-2 block text-sm text-gray-700">
                    Active
                </label>
            </div>

            <!-- Submit -->
            <div class="pt-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded">
                    Create Room Type
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
