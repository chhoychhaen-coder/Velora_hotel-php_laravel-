@extends('layouts.admin')

@section('title', 'Edit Hero Slide')
@section('page_title', 'Edit Hero Slide')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Hero Slide</h1>
        <a href="{{ route('admin.hero-slides.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.hero-slides.update', $slide) }}" method="POST" enctype="multipart/form-data" class="space-y-2">
            @csrf
            @method('PUT')
            @include('admin.hero-slides._form', ['slide' => $slide])
            <div class="pt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded">Update Slide</button>
            </div>
        </form>
    </div>
</div>
@endsection
