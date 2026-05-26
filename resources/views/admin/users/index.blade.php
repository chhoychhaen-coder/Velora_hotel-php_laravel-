@extends('layouts.admin')

@section('title', 'Users')
@section('page_title', 'Users')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6 p-4 rounded">
    <h1 class="text-3xl font-bold text-gray-800">Users</h1>
<a href="{{ route('admin.users.create') }}"
  class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
    Create User
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->role ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->phone ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">

    <div class="flex items-center gap-2">

        {{-- ROLE UPDATE --}}
        <form method="POST"
              action="{{ route('admin.users.update', $user) }}"
              class="flex items-center gap-2">

            @csrf
            @method('PATCH')

            <select name="role"
                    class="text-sm border border-gray-300 rounded-md px-7 py-1
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                @foreach (\App\Models\User::ROLES as $role)
                    <option value="{{ $role }}" @selected($user->role === $role)>
                        {{ ucfirst($role) }}
                    </option>
                @endforeach

            </select>

                            <button type="submit"
                        class="px-3 py-1 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
                    Update
                </button>

        </form>

        {{-- DELETE (hide self delete) --}}
        @unless (auth()->id() === $user->id)
            <form method="POST"
                  action="{{ route('admin.users.destroy', $user) }}"
                  onsubmit="return confirm('Delete this user?')">

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
        @endunless

    </div>

</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($users->hasPages())
    <div class="mt-6">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
