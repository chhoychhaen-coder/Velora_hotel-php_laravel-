@extends('layouts.admin')

@section('title', 'Create Testimonial')
@section('page_title', 'Create Testimonial')

@section('content')
<div class="container mx-auto px-4 py-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Create Testimonial</h1>

        <a href="{{ route('admin.testimonials.index') }}"
           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.testimonials.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- User -->
            <div>
                <label class="block text-sm font-medium text-gray-700">User</label>
                <select name="user_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        required>

                    <option value="">Select User</option>

                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                            @selected(old('user_id') == $user->id)>
                            {{ $user->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <!-- Content -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Content</label>
                <textarea name="content" rows="4"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                          required>{{ old('content') }}</textarea>
            </div>

            <!-- Rating -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Rating</label>
                <select name="rating"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        required>

                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" @selected(old('rating') == $i)>
                            {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                        </option>
                    @endfor

                </select>
            </div>

            <!-- Approved -->
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_approved" value="1"
                       {{ old('is_approved') ? 'checked' : '' }}>
                <label class="text-sm text-gray-700">Approve immediately</label>
            </div>

            <!-- Submit -->
            <div class="pt-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded">
                    Create Testimonial
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
