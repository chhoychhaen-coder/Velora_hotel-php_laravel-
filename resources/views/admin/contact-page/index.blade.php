@extends('layouts.admin')

@section('title', 'Contact Page')
@section('page_title', 'Contact Page')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Contact Page (Dynamic)</h1>
            <p class="text-sm text-gray-500 mt-1">Manage the public <a href="{{ route('contact') }}" target="_blank" rel="noopener" class="text-blue-600 hover:underline">Contact page</a>.</p>
        </div>
        <a href="{{ route('contact') }}" target="_blank" rel="noopener" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded text-sm">View frontend</a>
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
        <h2 class="text-lg font-bold text-gray-800 mb-4">Page header & map</h2>
        <form method="POST" action="{{ route('admin.contact-page.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700">Section label</label>
                <input type="text" name="section_label" value="{{ old('section_label', $contactPage->section_label) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Title highlight</label>
                <input type="text" name="title_highlight" value="{{ old('title_highlight', $contactPage->title_highlight) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Title (before highlight)</label>
                <input type="text" name="title" value="{{ old('title', $contactPage->title) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Google Maps embed URL</label>
                <textarea name="map_embed_url" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="https://www.google.com/maps/embed?pb=...">{{ old('map_embed_url', $contactPage->map_embed_url) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">
                    In Google Maps: <strong>Share → Embed a map → Copy HTML</strong>, then paste the full iframe or only the <code>src</code> URL.
                    Do not use short links (<code>maps.app.goo.gl</code>) — they will not display on the site.
                </p>
                @if($contactPage->map_embed_url && !\App\Models\ContactPage::normalizeMapEmbedUrl($contactPage->map_embed_url))
                    <p class="text-xs text-amber-700 mt-2">Current saved link is not a valid embed URL. The frontend shows the default map until you save a correct embed link.</p>
                @endif
            </div>
            <div class="md:col-span-2">
                <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $contactPage->is_active)) class="rounded border-gray-300">
                    Active (show on frontend)
                </label>
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded">Save page content</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
       

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Active</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($contactInfoItems as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form id="contact-info-update-{{ $item->id }}" method="POST" action="{{ route('admin.contact-info-items.update', $item) }}">
                                    @csrf
                                    @method('PUT')
                                </form>
                                <input form="contact-info-update-{{ $item->id }}" type="number" name="sort_order" value="{{ $item->sort_order }}" min="0" class="w-20 border-gray-300 rounded-md text-sm">
                            </td>
                            <td class="px-6 py-4">
                                <input form="contact-info-update-{{ $item->id }}" type="text" name="title" value="{{ $item->title }}" class="w-full min-w-[120px] border-gray-300 rounded-md text-sm" required>
                            </td>
                            <td class="px-6 py-4">
                                <input form="contact-info-update-{{ $item->id }}" type="email" name="email" value="{{ $item->email }}" class="w-full min-w-[200px] border-gray-300 rounded-md text-sm" required>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input form="contact-info-update-{{ $item->id }}" type="hidden" name="is_active" value="0">
                                <input form="contact-info-update-{{ $item->id }}" type="checkbox" name="is_active" value="1" @checked($item->is_active) class="rounded border-gray-300">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button form="contact-info-update-{{ $item->id }}" type="submit" class="text-indigo-600 hover:text-indigo-900 font-medium mr-3">Save</button>
                                <form method="POST" action="{{ route('admin.contact-info-items.destroy', $item) }}" class="inline" onsubmit="return confirm('Delete this contact info?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">No contact info yet. Add your first email box above.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
