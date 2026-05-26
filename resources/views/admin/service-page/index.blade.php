@extends('layouts.admin')

@section('title', 'Services Page')
@section('page_title', 'Services Page')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Services Page (Dynamic)</h1>
            <p class="text-sm text-gray-500 mt-1">Manage the public <a href="{{ route('service') }}" target="_blank" rel="noopener" class="text-blue-600 hover:underline">Services page</a>.</p>
        </div>
        <a href="{{ route('service') }}" target="_blank" rel="noopener" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded text-sm">View frontend</a>
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

    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Page header</h2>
        <form method="POST" action="{{ route('admin.service-page.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700">Section label</label>
                <input type="text" name="section_label" value="{{ old('section_label', $servicePage->section_label) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Title highlight</label>
                <input type="text" name="title_highlight" value="{{ old('title_highlight', $servicePage->title_highlight) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Title (before highlight)</label>
                <input type="text" name="title" value="{{ old('title', $servicePage->title) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="md:col-span-2">
                <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $servicePage->is_active)) class="rounded border-gray-300">
                    Active (show on frontend)
                </label>
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded">Save header</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50 flex flex-wrap justify-between items-center gap-3">
            <h2 class="text-lg font-bold text-gray-800">Service cards (frontend grid)</h2>
            <span class="text-xs text-gray-500">Icon examples: fa-bed, fa-utensils, fa-spa, fa-wifi</span>
        </div>

        <div class="p-6 border-b bg-gray-50">
            <form method="POST" action="{{ route('admin.service-items.store') }}" class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-600">Icon (Font Awesome)</label>
                    <input type="text" name="icon" value="fa-star" class="mt-1 block w-full border-gray-300 rounded-md text-sm" placeholder="fa-bed" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-600">Title</label>
                    <input type="text" name="title" class="mt-1 block w-full border-gray-300 rounded-md text-sm" placeholder="Room Accommodation" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-600">Description</label>
                    <input type="text" name="description" class="mt-1 block w-full border-gray-300 rounded-md text-sm" placeholder="Short description...">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600">Order</label>
                    <input type="number" name="sort_order" min="0" value="0" class="mt-1 block w-full border-gray-300 rounded-md text-sm">
                </div>
                <div class="md:col-span-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded text-sm">Add service</button>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Icon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Active</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($serviceItems as $item)
                        <tr>
                            <td class="px-6 py-4 align-top whitespace-nowrap">
                                <form id="service-item-update-{{ $item->id }}" method="POST" action="{{ route('admin.service-items.update', $item) }}">
                                    @csrf
                                    @method('PUT')
                                </form>
                                <input form="service-item-update-{{ $item->id }}" type="number" name="sort_order" value="{{ $item->sort_order }}" min="0" class="w-20 border-gray-300 rounded-md text-sm">
                            </td>
                            <td class="px-6 py-4 align-top whitespace-nowrap">
                                <i class="{{ $item->iconClass() }} fa-2x text-blue-600 mb-2"></i>
                                <input form="service-item-update-{{ $item->id }}" type="text" name="icon" value="{{ $item->icon }}" class="w-28 border-gray-300 rounded-md text-sm" required>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <input form="service-item-update-{{ $item->id }}" type="text" name="title" value="{{ $item->title }}" class="w-full min-w-[160px] border-gray-300 rounded-md text-sm font-semibold" required>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <textarea form="service-item-update-{{ $item->id }}" name="description" rows="2" class="w-full min-w-[220px] border-gray-300 rounded-md text-sm">{{ $item->description }}</textarea>
                            </td>
                            <td class="px-6 py-4 align-top whitespace-nowrap">
                                <input form="service-item-update-{{ $item->id }}" type="hidden" name="is_active" value="0">
                                <input form="service-item-update-{{ $item->id }}" type="checkbox" name="is_active" value="1" @checked($item->is_active) class="rounded border-gray-300">
                            </td>
                            <td class="px-6 py-4 align-top whitespace-nowrap">
                                <button form="service-item-update-{{ $item->id }}" type="submit" class="text-indigo-600 hover:text-indigo-900 font-medium block mb-2">Save</button>
                                <form method="POST" action="{{ route('admin.service-items.destroy', $item) }}" onsubmit="return confirm('Delete this service?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">No services yet. Add your first service card above.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
