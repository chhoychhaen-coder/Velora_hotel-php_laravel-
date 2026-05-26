@extends('layouts.admin')

@section('title', 'About Page')
@section('page_title', 'About Page')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">About Page (Dynamic)</h1>
            <p class="text-sm text-gray-500 mt-1">Edit content shown on the public <a href="{{ route('about') }}" target="_blank" rel="noopener" class="text-blue-600 hover:underline">About page</a>.</p>
        </div>
        <a href="{{ route('about') }}" target="_blank" rel="noopener" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded text-sm">View frontend</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc ml-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Main content --}}
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Main content</h2>
        <form method="POST" action="{{ route('admin.about-page.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700">Section label</label>
                <input type="text" name="section_label" value="{{ old('section_label', $aboutPage->section_label) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Title highlight (colored text)</label>
                <input type="text" name="title_highlight" value="{{ old('title_highlight', $aboutPage->title_highlight) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Title (before highlight)</label>
                <input type="text" name="title" value="{{ old('title', $aboutPage->title) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Paragraph 1</label>
                <textarea name="paragraph_one" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('paragraph_one', $aboutPage->paragraph_one) }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Paragraph 2</label>
                <textarea name="paragraph_two" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('paragraph_two', $aboutPage->paragraph_two) }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $aboutPage->is_active)) class="rounded border-gray-300">
                    Active (show on frontend)
                </label>
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded">Save main content</button>
            </div>
        </form>
    </div>

    {{-- Features table --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800">Feature list (checkmarks)</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title (frontend)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Active</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($features as $feature)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form id="feature-update-{{ $feature->id }}" method="POST" action="{{ route('admin.about-features.update', $feature) }}">
                                    @csrf
                                    @method('PUT')
                                </form>
                                <input form="feature-update-{{ $feature->id }}" type="number" name="sort_order" value="{{ $feature->sort_order }}" min="0" class="w-20 border-gray-300 rounded-md text-sm">
                            </td>
                            <td class="px-6 py-4">
                                <input form="feature-update-{{ $feature->id }}" type="text" name="title" value="{{ $feature->title }}" class="w-full max-w-md border-gray-300 rounded-md text-sm" required>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input form="feature-update-{{ $feature->id }}" type="hidden" name="is_active" value="0">
                                <input form="feature-update-{{ $feature->id }}" type="checkbox" name="is_active" value="1" @checked($feature->is_active) class="rounded border-gray-300">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button form="feature-update-{{ $feature->id }}" type="submit" class="text-indigo-600 hover:text-indigo-900 font-medium mr-3">Save</button>
                                <form method="POST" action="{{ route('admin.about-features.destroy', $feature) }}" class="inline" onsubmit="return confirm('Delete this feature?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">No features yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Gallery table --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Preview</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Size / Align</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Active</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($galleryImages as $image)
                        <tr>
                            <td class="px-6 py-4 align-top">
                                <form id="gallery-update-{{ $image->id }}" method="POST" action="{{ route('admin.about-gallery.update', $image) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                </form>
                                <input form="gallery-update-{{ $image->id }}" type="number" name="sort_order" value="{{ $image->sort_order }}" min="0" class="w-20 border-gray-300 rounded-md text-sm">
                            </td>
                            <td class="px-6 py-4 align-top">
                                <img src="{{ $image->imageUrl() }}" alt="" class="h-16 w-24 rounded object-cover border mb-2">
                                <input form="gallery-update-{{ $image->id }}" type="file" name="image" accept="image/*" class="block w-full text-xs text-gray-600">
                            </td>
                            <td class="px-6 py-4 align-top">
                                <select form="gallery-update-{{ $image->id }}" name="size_class" class="block w-full border-gray-300 rounded-md text-sm mb-2">
                                    <option value="w-50" @selected($image->size_class === 'w-50')>w-50</option>
                                    <option value="w-75" @selected($image->size_class === 'w-75')>w-75</option>
                                    <option value="w-100" @selected($image->size_class === 'w-100')>w-100</option>
                                </select>
                                <select form="gallery-update-{{ $image->id }}" name="align_class" class="block w-full border-gray-300 rounded-md text-sm">
                                    <option value="text-start" @selected($image->align_class === 'text-start')>Left</option>
                                    <option value="text-end" @selected($image->align_class === 'text-end')>Right</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 align-top whitespace-nowrap">
                                <input form="gallery-update-{{ $image->id }}" type="hidden" name="is_active" value="0">
                                <input form="gallery-update-{{ $image->id }}" type="checkbox" name="is_active" value="1" @checked($image->is_active) class="rounded border-gray-300">
                            </td>
                            <td class="px-6 py-4 align-top whitespace-nowrap">
                                <button form="gallery-update-{{ $image->id }}" type="submit" class="text-indigo-600 hover:text-indigo-900 font-medium block mb-2">Save</button>
                                <form method="POST" action="{{ route('admin.about-gallery.destroy', $image) }}" onsubmit="return confirm('Delete this image?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No gallery images yet. Defaults from theme are used on frontend.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
