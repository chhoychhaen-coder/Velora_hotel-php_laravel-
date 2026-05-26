@extends('layouts.admin')

@section('title', 'Rooms')
@section('page_title', 'Rooms')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6 p-4 rounded">
    <h1 class="text-3xl font-bold text-gray-800">Rooms</h1>
<a href="{{ route('admin.rooms.create') }}"
  class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
    Create Room
</a>
</div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Floor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($rooms as $room)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $room->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $room->room_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $room->roomType->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $room->floor ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($room->status === 'available')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Available</span>
                            @elseif($room->status === 'occupied')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Occupied</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Maintenance</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($room->notes, 50) }}</td>
                       <td class="px-6 py-4 whitespace-nowrap text-sm">

    <div class="flex items-center gap-2">

        {{-- UPDATE --}}
        <a href="{{ route('admin.rooms.edit', $room) }}"
           class="px-3 py-1 text-sm bg-blue-600 hover:bg-blue-700
                  text-white rounded-md transition flex items-center gap-1">

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
              action="{{ route('admin.rooms.destroy', $room) }}"
              onsubmit="return confirm('Delete this room?')">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="px-3 py-1 text-sm bg-red-600 hover:bg-red-700
                           text-white rounded-md transition flex items-center gap-1">

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

    </div>

</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No rooms found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
