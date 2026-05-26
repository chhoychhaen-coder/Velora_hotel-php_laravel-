@extends('layouts.admin')

@section('title', 'Booking Page')
@section('page_title', 'Booking Page Images')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Booking Page (Images)</h1>
            <p class="text-sm text-gray-500 mt-1">Manage the image gallery on the public <a href="{{ route('booking') }}" target="_blank" rel="noopener" class="text-blue-600 hover:underline">Booking page</a>. Booking form fields stay unchanged.</p>
        </div>
        <a href="{{ route('booking') }}" target="_blank" rel="noopener" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded text-sm">View frontend</a>
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

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800">Booking page gallery</h2>
            <p class="text-xs text-gray-500 mt-1">Use <strong>Add image</strong> below to upload a new file. To replace an existing row, choose a file in that row then click Save.</p>
        </div>

        <div class="p-6 border-b bg-gray-50">
            <form method="POST" action="{{ route('admin.booking-page-images.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
                @csrf
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-600">Image</label>
                    <input type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.webp,image/*" class="mt-1 block w-full text-sm text-gray-600" required>
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF, or WebP. Max 5 MB.</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600">Width class</label>
                    <select name="size_class" class="mt-1 block w-full border-gray-300 rounded-md text-sm">
                        <option value="w-50">w-50</option>
                        <option value="w-75" selected>w-75</option>
                        <option value="w-100">w-100</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600">Align</label>
                    <select name="align_class" class="mt-1 block w-full border-gray-300 rounded-md text-sm">
                        <option value="text-start">Left</option>
                        <option value="text-end">Right</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600">Order</label>
                    <input type="number" name="sort_order" min="0" value="0" class="mt-1 block w-full border-gray-300 rounded-md text-sm">
                </div>
                <div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded text-sm w-full">Add image</button>
                </div>
                <div class="md:col-span-6">
                    <label class="block text-xs font-medium text-gray-600">Extra CSS (optional)</label>
                    <input type="text" name="extra_style" class="mt-1 block w-full border-gray-300 rounded-md text-sm" placeholder="margin-top: 25%;">
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Preview</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Size / Align</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Style</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Active</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($bookingImages as $image)
                        <tr>
                            <td class="px-6 py-4 align-top">
                                <form id="booking-image-update-{{ $image->id }}" method="POST" action="{{ route('admin.booking-page-images.update', $image) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                </form>
                                <input form="booking-image-update-{{ $image->id }}" type="number" name="sort_order" value="{{ $image->sort_order }}" min="0" class="w-20 border-gray-300 rounded-md text-sm">
                            </td>
                            <td class="px-6 py-4 align-top">
                                <img src="{{ $image->imageUrl() }}" alt="" class="h-16 w-24 rounded object-cover border mb-2">
                                <input form="booking-image-update-{{ $image->id }}" type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.webp,image/*" class="block w-full text-xs text-gray-600">
                                <span class="text-xs text-gray-400">Optional — pick file to replace</span>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <select form="booking-image-update-{{ $image->id }}" name="size_class" class="block w-full border-gray-300 rounded-md text-sm mb-2">
                                    <option value="w-50" @selected($image->size_class === 'w-50')>w-50</option>
                                    <option value="w-75" @selected($image->size_class === 'w-75')>w-75</option>
                                    <option value="w-100" @selected($image->size_class === 'w-100')>w-100</option>
                                </select>
                                <select form="booking-image-update-{{ $image->id }}" name="align_class" class="block w-full border-gray-300 rounded-md text-sm">
                                    <option value="text-start" @selected($image->align_class === 'text-start')>Left</option>
                                    <option value="text-end" @selected($image->align_class === 'text-end')>Right</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <input form="booking-image-update-{{ $image->id }}" type="text" name="extra_style" value="{{ $image->extra_style }}" class="w-full min-w-[140px] border-gray-300 rounded-md text-sm" placeholder="margin-top: 25%;">
                            </td>
                            <td class="px-6 py-4 align-top whitespace-nowrap">
                                <input form="booking-image-update-{{ $image->id }}" type="hidden" name="is_active" value="0">
                                <input form="booking-image-update-{{ $image->id }}" type="checkbox" name="is_active" value="1" @checked($image->is_active) class="rounded border-gray-300">
                            </td>
                            <td class="px-6 py-4 align-top whitespace-nowrap">
                                <button form="booking-image-update-{{ $image->id }}" type="submit" class="text-indigo-600 hover:text-indigo-900 font-medium block mb-2">Save</button>
                                <form method="POST" action="{{ route('admin.booking-page-images.destroy', $image) }}" onsubmit="return confirm('Delete this image?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">No images yet. Defaults from theme are used on frontend.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
