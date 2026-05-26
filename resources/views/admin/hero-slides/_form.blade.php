@php
    $slide = $slide ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-medium text-gray-700">Kicker</label>
        <input type="text" name="kicker" value="{{ old('kicker', $slide?->kicker) }}" placeholder="Velora Hotel"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Sort order</label>
        <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $slide?->sort_order ?? 0) }}"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
</div>

<div class="mt-5">
    <label class="block text-sm font-medium text-gray-700">Headline *</label>
    <input type="text" name="title" value="{{ old('title', $slide?->title) }}" required
           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
</div>

<div class="mt-5">
    <label class="block text-sm font-medium text-gray-700">Description</label>
    <textarea name="body" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('body', $slide?->body) }}</textarea>
</div>

<div class="mt-5">
    <label class="block text-sm font-medium text-gray-700">Background image {{ $slide ? '' : '(optional)' }}</label>
    <input type="file" name="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-700">
    @if($slide?->image_path)
        <img src="{{ $slide->imageUrl() }}" alt="" class="mt-3 h-24 w-40 rounded object-cover border border-gray-200">
    @endif
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
    <div>
        <label class="block text-sm font-medium text-gray-700">Primary button label *</label>
        <input type="text" name="primary_button_label" value="{{ old('primary_button_label', $slide?->primary_button_label ?? 'Explore Rooms') }}" required
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Primary button link *</label>
        <input type="text" name="primary_button_link" value="{{ old('primary_button_link', $slide?->primary_button_link ?? '/rooms') }}" required
               placeholder="/rooms"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Secondary button label</label>
        <input type="text" name="secondary_button_label" value="{{ old('secondary_button_label', $slide?->secondary_button_label) }}"
               placeholder="Book Now"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Secondary button link</label>
        <input type="text" name="secondary_button_link" value="{{ old('secondary_button_link', $slide?->secondary_button_link) }}"
               placeholder="/booking"
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
</div>

<div class="mt-5">
    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $slide?->is_active ?? true)) class="rounded border-gray-300">
        Active (show on home page)
    </label>
</div>
