@extends('layouts.admin')

@section('title', 'Room Types')
@section('page_title', 'Room Types')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6 p-4 rounded">
    <h1 class="text-3xl font-bold text-gray-800">Room Types</h1>
<a href="{{ route('admin.room-types.create') }}"
  class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
    Create Room Type
</a>
</div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capacity Adults</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capacity Children</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price/Night</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Active</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($roomTypes as $roomType)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $roomType->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($roomType->display_image_url)
                                <img src="{{ $roomType->display_image_url }}"
                                     alt="{{ $roomType->name }}"
                                     class="h-14 w-20 object-cover rounded-md border">
                            @else
                                <span class="text-sm text-gray-400">No image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $roomType->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($roomType->description, 50) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $roomType->capacity_adults }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $roomType->capacity_children }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($roomType->price_per_night, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($roomType->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-3 items-center">

    {{-- UPDATE (link to edit page) --}}
    <a href="{{ route('admin.room-types.edit', $roomType) }}"
       class="px-3 py-1 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-md transition flex items-center gap-1">

        <!-- edit icon -->
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-4 w-4"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11 15l-4 1 1-4 7.586-7.586z"/>
        </svg>

        Edit
    </a>

    {{-- DELETE --}}
    <form method="POST"
          action="{{ route('admin.room-types.destroy', $roomType) }}"
          onsubmit="return confirm('Delete this room type?')">
        @csrf
        @method('DELETE')

        <button type="submit"
                class="px-3 py-1 text-sm bg-red-600 hover:bg-red-700 text-white rounded-md transition flex items-center gap-1">

            <!-- trash icon -->
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-4 w-4"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>

            Delete
        </button>
    </form>

</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">No room types found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($roomTypes->hasPages())
    <div class="mt-6">
        {{ $roomTypes->links() }}
    </div>
    @endif
</div>
@endsection
