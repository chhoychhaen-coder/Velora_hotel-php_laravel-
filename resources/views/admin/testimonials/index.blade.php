@extends('layouts.admin')

@section('title', 'Testimonials')
@section('page_title', 'Testimonials')

@section('content')
<div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6 p-4 rounded">
    <h1 class="text-3xl font-bold text-gray-800">Testimonials</h1>
<a href="{{ route('admin.testimonials.create') }}"
  class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
    Create Testimonial
</a>
</div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Approved</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($testimonials as $testimonial)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $testimonial->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $testimonial->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($testimonial->content, 100) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $testimonial->rating)
                                        <span class="text-yellow-400">★</span>
                                    @else
                                        <span class="text-gray-300">★</span>
                                    @endif
                                @endfor
                                <span class="ml-2 text-sm">{{ $testimonial->rating }}/5</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($testimonial->is_approved)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $testimonial->created_at->format('Y-m-d H:i') }}</td>
                       <td class="px-6 py-4 whitespace-nowrap text-sm">

    <div class="flex items-center gap-2">

        {{-- UPDATE STATUS --}}
        <form method="POST"
              action="{{ route('admin.testimonials.update', $testimonial) }}"
              class="flex items-center gap-2">

            @csrf
            @method('PATCH')

            <select name="is_approved"
                    class="text-sm border border-gray-300 rounded-md px-6.3 py-1
                           focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500">

                <option value="0" @selected(! $testimonial->is_approved)>
                    Pending
                </option>

                <option value="1" @selected($testimonial->is_approved)>
                    Approved
                </option>

            </select>

                 <button type="submit"
                        class="px-3 py-1 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
                    Update
                </button>

        </form>

        {{-- DELETE --}}
        <form method="POST"
              action="{{ route('admin.testimonials.destroy', $testimonial) }}"
              onsubmit="return confirm('Delete this testimonial?')">

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
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No testimonials found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($testimonials->hasPages())
    <div class="mt-6">
        {{ $testimonials->links() }}
    </div>
    @endif
</div>
@endsection
