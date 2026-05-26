@extends('layouts.admin')

@section('title', 'Home Slideshow')
@section('page_title', 'Home Slideshow')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6 p-4 rounded">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Home Slideshow</h1>
            <p class="text-sm text-gray-500 mt-1">Backend table below maps to what appears on the frontend home hero and inner page banners.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded text-sm">View frontend</a>
            <a href="{{ route('admin.hero-slides.create') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Add Slide</a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Frontend &amp; Backend</h2>
            <p class="text-xs text-gray-500 mt-1">
                <strong>Home hero</strong> = image + title + text + buttons &nbsp;|&nbsp;
                <strong>Page banners</strong> (About, Rooms, Contact…) = slideshow images only
            </p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-sm">
                <thead>
                    <tr class="bg-slate-800 text-xs font-medium text-white uppercase tracking-wider">
                        <th class="px-4 py-3 text-left" colspan="6">Backend (stored in database)</th>
                        <th class="px-4 py-3 text-left bg-emerald-700" colspan="2">Frontend (public website)</th>
                        <th class="px-4 py-3 text-left"></th>
                    </tr>
                    <tr class="bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <th class="px-4 py-3 text-left">Order</th>
                        <th class="px-4 py-3 text-left">Image</th>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-left">Kicker</th>
                        <th class="px-4 py-3 text-left">Buttons</th>
                        <th class="px-4 py-3 text-left">Active</th>
                        <th class="px-4 py-3 text-left bg-emerald-50 text-emerald-800">Home hero</th>
                        <th class="px-4 py-3 text-left bg-emerald-50 text-emerald-800">Page banners</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($slides as $slide)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 whitespace-nowrap font-semibold text-gray-900">{{ $slide->sort_order }}</td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <img src="{{ $slide->imageUrl() }}" alt="" class="h-14 w-24 rounded object-cover border border-gray-200">
                            </td>
                            <td class="px-4 py-4 text-gray-900">
                                <div class="font-semibold">{{ $slide->title }}</div>
                                <div class="text-gray-500 text-xs mt-1 max-w-xs">{{ Str::limit($slide->body, 70) }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-gray-700">{{ $slide->kicker ?? '—' }}</td>
                            <td class="px-4 py-4 text-xs text-gray-600 max-w-[140px]">
                                <div>{{ $slide->primary_button_label }}</div>
                                @if($slide->secondary_button_label)
                                    <div class="text-gray-400">{{ $slide->secondary_button_label }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @if($slide->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-700">Hidden</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 bg-emerald-50/40 text-emerald-900 text-xs whitespace-nowrap">
                                @if($slide->is_active)
                                    <span class="font-semibold">Shown</span><br>image + text + buttons
                                @else
                                    <span class="text-gray-400">Hidden</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 bg-emerald-50/40 text-emerald-900 text-xs whitespace-nowrap">
                                @if($slide->is_active)
                                    <span class="font-semibold">Shown</span><br>image only
                                @else
                                    <span class="text-gray-400">Hidden</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex flex-col gap-1">
                                    <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                                    <form method="POST" action="{{ route('admin.hero-slides.destroy', $slide) }}" onsubmit="return confirm('Delete this slide?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-left">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-10 text-center text-gray-500">
                                No slides yet.
                                <a href="{{ route('admin.hero-slides.create') }}" class="text-blue-600 hover:underline">Add your first slide</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($slides->hasPages())
        <div>{{ $slides->links() }}</div>
    @endif
</div>
@endsection
