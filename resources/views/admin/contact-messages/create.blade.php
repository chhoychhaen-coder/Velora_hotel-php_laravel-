@extends('layouts.admin')

@section('title', 'Create Contact Message')
@section('page_title', 'Create Contact Message')

@section('content')
<div class="container mx-auto px-4 py-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Create Contact Message</h1>
        <a href="{{ route('admin.contact-messages.index') }}"
           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">

        <form action="{{ route('admin.contact-messages.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                       required>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                       required>
            </div>

            <!-- Subject -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Subject</label>
                <input type="text" name="subject"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Message -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Message</label>
                <textarea name="message" rows="5"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                          required></textarea>
            </div>

            <!-- Read Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="is_read"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="0">Unread</option>
                    <option value="1">Read</option>
                </select>
            </div>

            <!-- Submit -->
            <div class="pt-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded">
                    Save Message
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
