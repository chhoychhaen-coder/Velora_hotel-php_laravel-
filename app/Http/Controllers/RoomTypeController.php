<?php

namespace App\Http\Controllers;

use App\Helpers\ImageStorage;
use App\Models\RoomType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomTypeController extends Controller
{
    public function index(): View
    {
        return view('admin.room-types.index', [
            'roomTypes' => RoomType::latest('id')->paginate(10),
        ]);
    }
public function create(): View
    {
        return view('admin.room-types.create');
    }

    public function edit(RoomType $roomType): View
    {
        return view('admin.room-types.edit', [
            'roomType' => $roomType,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'capacity_adults' => ['required', 'integer', 'min:1'],
            'capacity_children' => ['required', 'integer', 'min:0'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image_url'] = ImageStorage::store($request->file('image'), 'room-types');
        }

        unset($validated['image']);

        RoomType::create($validated);
         return redirect()
        ->route('admin.room-types.index')
        ->with('success', 'Room type created successfully.');
    }

    public function update(Request $request, RoomType $roomType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'capacity_adults' => ['required', 'integer', 'min:1'],
            'capacity_children' => ['required', 'integer', 'min:0'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            ImageStorage::delete($roomType->image_url);
            $validated['image_url'] = ImageStorage::store($request->file('image'), 'room-types');
        }

        unset($validated['image']);

        $roomType->update($validated);

        return redirect()
        ->route('admin.room-types.index')
        ->with('success', 'Room type updated successfully.');
    }

    public function destroy(RoomType $roomType): RedirectResponse
    {
        ImageStorage::delete($roomType->image_url);

        $roomType->delete();

        return back()->with('success', 'Room type deleted successfully.');
    }

}
