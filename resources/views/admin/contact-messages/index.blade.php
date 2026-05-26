@extends('layouts.admin')

@section('title', 'Contact Messages')
@section('page_title', 'Contact Messages')

@section('content')
<div class="container mx-auto px-4 py-8">

    <div class="flex justify-between items-center mb-6 p-4 rounded">
        <h1 class="text-3xl font-bold text-gray-800">Contact Messages</h1>

        <a href="{{ route('admin.contact-messages.create') }}"
           class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
            Create Message
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Read</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($contactMessages as $message)
                  <tr class="hover:bg-gray-50 transition">

    <!-- ID -->
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
        #{{ $message->id }}
    </td>

    <!-- Name -->
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $message->name }}
    </td>

    <!-- Email -->
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $message->email }}
    </td>

    <!-- Subject -->
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        {{ $message->subject ?? 'N/A' }}
    </td>

    <!-- Message -->


    <!-- Status -->
    <td class="px-6 py-4 whitespace-nowrap text-sm">
        @if($message->is_read)
            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                ✓ Read
            </span>
        @else
            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                ⏳ Unread
            </span>
        @endif
    </td>

    <!-- Date -->
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
        {{ $message->created_at->format('Y-m-d H:i') }}
    </td>

    <!-- Actions -->
    <td class="px-6 py-4 whitespace-nowrap text-sm">

        <div class="flex items-center gap-3">

            <a href="{{ route('admin.contact-messages.show', $message) }}"
               class="px-3 py-1 text-sm bg-slate-700 hover:bg-slate-800 text-white rounded-md transition">
                View
            </a>

            <!-- UPDATE -->
            <form method="POST"
                  action="{{ route('admin.contact-messages.update', $message) }}"
                  class="flex items-center gap-2">

                @csrf
                @method('PATCH')

                <select name="is_read"
                        class="text-sm border-gray-300 rounded-md focus:ring focus:ring-blue-200">

                    <option value="0" @selected(! $message->is_read)>Unread</option>
                    <option value="1" @selected($message->is_read)>Read</option>

                </select>

                <button type="submit"
                        class="px-3 py-1 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
                    Update
                </button>

            </form>

            <!-- DELETE -->
            <form method="POST"
                  action="{{ route('admin.contact-messages.destroy', $message) }}"
                  onsubmit="return confirm('Delete this message?')">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="flex items-center gap-1 px-3 py-1 text-sm bg-red-600 hover:bg-red-700 text-white rounded-md transition">

                    <!-- icon -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />

                    </svg>

                    Delete
                </button>

            </form>

        </div>

    </td>

</tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">No contact messages found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($contactMessages->hasPages())
    <div class="mt-6">
        {{ $contactMessages->links() }}
    </div>
    @endif
</div>
@endsection
