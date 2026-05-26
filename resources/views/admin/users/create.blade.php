@extends('layouts.admin')

@section('title', 'Create User')
@section('page_title', 'Create User')

@section('content')
<div class="container mx-auto px-4 py-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Create User</h1>

        <a href="{{ route('admin.users.index') }}"
           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">

        {{-- ERROR MESSAGE --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name"
                       value="{{ old('name') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                       required>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                       required>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                       required>
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" name="phone"
                       value="{{ old('phone') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Role -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">

                    @foreach($roles as $role)
                        <option value="{{ $role }}"
                            @selected(old('role') == $role)>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach

                </select>
            </div>

            <!-- Submit -->
            <div class="pt-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded">
                    Create User
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
