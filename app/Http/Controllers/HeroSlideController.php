<?php

namespace App\Http\Controllers;

use App\Helpers\ImageStorage;
use App\Models\HeroSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    public function index(): View
    {
        return view('admin.hero-slides.index', [
            'slides' => HeroSlide::query()->orderBy('sort_order')->orderBy('id')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.hero-slides.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['image_path'] = $this->storeImage($request);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);

        HeroSlide::create($validated);

        return redirect()
            ->route('admin.hero-slides.index')
            ->with('success', 'Hero slide created successfully.');
    }

    public function edit(HeroSlide $heroSlide): View
    {
        return view('admin.hero-slides.edit', [
            'slide' => $heroSlide,
        ]);
    }

    public function update(Request $request, HeroSlide $heroSlide): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            ImageStorage::delete($heroSlide->image_path);
            $validated['image_path'] = ImageStorage::store($request->file('image'), 'hero-slides');
        }

        $heroSlide->update($validated);

        return redirect()
            ->route('admin.hero-slides.index')
            ->with('success', 'Hero slide updated successfully.');
    }

    public function destroy(HeroSlide $heroSlide): RedirectResponse
    {
        ImageStorage::delete($heroSlide->image_path);
        $heroSlide->delete();

        return redirect()
            ->route('admin.hero-slides.index')
            ->with('success', 'Hero slide deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'kicker' => ['nullable', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string', 'max:1000'],
            'primary_button_label' => ['required', 'string', 'max:80'],
            'primary_button_link' => ['required', 'string', 'max:255'],
            'secondary_button_label' => ['nullable', 'string', 'max:80'],
            'secondary_button_link' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);
    }

    private function storeImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        return ImageStorage::store($request->file('image'), 'hero-slides');
    }
}
