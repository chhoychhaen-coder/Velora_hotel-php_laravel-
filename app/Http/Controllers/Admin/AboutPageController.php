<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageStorage;
use App\Http\Controllers\Controller;
use App\Models\AboutFeature;
use App\Models\AboutGalleryImage;
use App\Models\AboutPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutPageController extends Controller
{
    public function index(): View
    {
        return view('admin.about-page.index', [
            'aboutPage' => AboutPage::current(),
            'features' => AboutFeature::query()->orderBy('sort_order')->orderBy('id')->get(),
            'galleryImages' => AboutGalleryImage::query()->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function updateContent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'section_label' => ['required', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:255'],
            'title_highlight' => ['required', 'string', 'max:255'],
            'paragraph_one' => ['nullable', 'string', 'max:5000'],
            'paragraph_two' => ['nullable', 'string', 'max:5000'],
            'button_label' => ['required', 'string', 'max:80'],
            'button_link' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        AboutPage::current()->update($validated);

        return back()->with('success', 'About page content updated.');
    }

    public function storeFeature(Request $request): RedirectResponse
    {
        AboutFeature::create($request->validate([
            'title' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'sort_order' => $request->input('sort_order', 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Feature added.');
    }

    public function updateFeature(Request $request, AboutFeature $aboutFeature): RedirectResponse
    {
        $aboutFeature->update($request->validate([
            'title' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Feature updated.');
    }

    public function destroyFeature(AboutFeature $aboutFeature): RedirectResponse
    {
        $aboutFeature->delete();

        return back()->with('success', 'Feature deleted.');
    }

    public function storeGalleryImage(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'max:5120'],
            'size_class' => ['required', 'string', 'max:20'],
            'align_class' => ['required', 'string', 'max:20'],
            'extra_style' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        AboutGalleryImage::create([
            'image_path' => ImageStorage::store($request->file('image'), 'about-gallery'),
            'size_class' => $validated['size_class'],
            'align_class' => $validated['align_class'],
            'extra_style' => $validated['extra_style'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Gallery image added.');
    }

    public function updateGalleryImage(Request $request, AboutGalleryImage $aboutGalleryImage): RedirectResponse
    {
        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:5120'],
            'size_class' => ['required', 'string', 'max:20'],
            'align_class' => ['required', 'string', 'max:20'],
            'extra_style' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            ImageStorage::delete($aboutGalleryImage->image_path);
            $validated['image_path'] = ImageStorage::store($request->file('image'), 'about-gallery');
        }

        unset($validated['image']);
        $validated['is_active'] = $request->boolean('is_active');

        $aboutGalleryImage->update($validated);

        return back()->with('success', 'Gallery image updated.');
    }

    public function destroyGalleryImage(AboutGalleryImage $aboutGalleryImage): RedirectResponse
    {
        ImageStorage::delete($aboutGalleryImage->image_path);
        $aboutGalleryImage->delete();

        return back()->with('success', 'Gallery image deleted.');
    }
}
