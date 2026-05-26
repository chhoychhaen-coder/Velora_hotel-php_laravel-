@extends('layouts.admin')

@section('title', 'Footer')
@section('page_title', 'Footer (Dynamic)')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Footer (Dynamic)</h1>
            <p class="text-sm text-gray-500 mt-1">Edit footer text, contact info, and social icons. Company and guest links are fixed on the site.</p>
        </div>
        <a href="{{ route('home') }}" target="_blank" rel="noopener" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded text-sm">View frontend</a>
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
        <h2 class="text-lg font-bold text-gray-800 mb-4">Main footer content</h2>
        <form method="POST" action="{{ route('admin.footer-page.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700">Brand name</label>
                <input type="text" name="brand_name" value="{{ old('brand_name', $footerSetting->brand_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Copyright text</label>
                <input type="text" name="copyright_text" value="{{ old('copyright_text', $footerSetting->copyright_text) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Tagline</label>
                <textarea name="tagline" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('tagline', $footerSetting->tagline) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Company section title</label>
                <input type="text" name="company_section_title" value="{{ old('company_section_title', $footerSetting->company_section_title) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Guest section title</label>
                <input type="text" name="guest_section_title" value="{{ old('guest_section_title', $footerSetting->guest_section_title) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Contact section title</label>
                <input type="text" name="contact_section_title" value="{{ old('contact_section_title', $footerSetting->contact_section_title) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" value="{{ old('address', $footerSetting->address) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $footerSetting->phone) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $footerSetting->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>


            <div class="md:col-span-2">
                <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $footerSetting->is_active)) class="rounded border-gray-300">
                    Active (show dynamic footer on frontend)
                </label>
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded">Save footer settings</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">


        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Label</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">URL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Icon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Active</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($socialLinks as $link)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form id="footer-link-update-{{ $link->id }}" method="POST" action="{{ route('admin.footer-links.update', $link) }}">
                                    @csrf
                                    @method('PUT')
                                </form>
                                <input form="footer-link-update-{{ $link->id }}" type="number" name="sort_order" value="{{ $link->sort_order }}" min="0" class="w-20 border-gray-300 rounded-md text-sm">
                            </td>
                            <td class="px-6 py-4">
                                <input form="footer-link-update-{{ $link->id }}" type="text" name="label" value="{{ $link->label }}" class="w-full min-w-[120px] border-gray-300 rounded-md text-sm" required>
                            </td>
                            <td class="px-6 py-4">
                                <input form="footer-link-update-{{ $link->id }}" type="text" name="url" value="{{ $link->url }}" class="w-full min-w-[140px] border-gray-300 rounded-md text-sm">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <i class="{{ $link->iconClass() }} mb-2"></i>
                                <input form="footer-link-update-{{ $link->id }}" type="text" name="icon" value="{{ $link->icon }}" class="w-28 border-gray-300 rounded-md text-sm block">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input form="footer-link-update-{{ $link->id }}" type="hidden" name="is_active" value="0">
                                <input form="footer-link-update-{{ $link->id }}" type="checkbox" name="is_active" value="1" @checked($link->is_active) class="rounded border-gray-300">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button form="footer-link-update-{{ $link->id }}" type="submit" class="text-indigo-600 hover:text-indigo-900 font-medium mr-3">Save</button>
                                <form method="POST" action="{{ route('admin.footer-links.destroy', $link) }}" class="inline" onsubmit="return confirm('Delete this link?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">No social links yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
