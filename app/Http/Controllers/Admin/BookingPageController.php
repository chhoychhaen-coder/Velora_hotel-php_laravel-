<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageStorage;
use App\Http\Controllers\Controller;
use App\Models\BookingPageImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingPageController extends Controller
{
    public function index(): View
    {
        return view('admin.booking-page.index', [
            'bookingImages' => BookingPageImage::query()->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function storeImage(Request $request): RedirectResponse
    {
        if (! $request->hasFile('image')) {
            return back()
                ->withInput()
                ->withErrors([
                    'image' => 'No image was received. Choose a JPG, PNG, GIF, or WebP file under 5 MB.',
                ]);
        }

        $validated = $request->validate([
            'image' => ['required', 'file', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'size_class' => ['required', 'string', 'max:20'],
            'align_class' => ['required', 'string', 'max:20'],
            'extra_style' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'image.mimes' => 'Only JPG, PNG, GIF, or WebP images are allowed.',
            'image.max' => 'Image must be 5 MB or smaller.',
        ]);

        try {
            $imagePath = ImageStorage::store($request->file('image'), 'booking-gallery');
        } catch (\Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->withErrors(['image' => $exception->getMessage()]);
        }

        BookingPageImage::create([
            'image_path' => $imagePath,
            'size_class' => $validated['size_class'],
            'align_class' => $validated['align_class'],
            'extra_style' => $validated['extra_style'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Booking page image added.');
    }

    public function updateImage(Request $request, BookingPageImage $bookingPageImage): RedirectResponse
    {
        $validated = $request->validate([
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'size_class' => ['required', 'string', 'max:20'],
            'align_class' => ['required', 'string', 'max:20'],
            'extra_style' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'image.mimes' => 'Only JPG, PNG, GIF, or WebP images are allowed.',
            'image.max' => 'Image must be 5 MB or smaller.',
        ]);

        if ($request->hasFile('image')) {
            try {
                ImageStorage::delete($bookingPageImage->image_path);
                $validated['image_path'] = ImageStorage::store($request->file('image'), 'booking-gallery');
            } catch (\Throwable $exception) {
                report($exception);

                return back()
                    ->withInput()
                    ->withErrors(['image' => $exception->getMessage()]);
            }
        }

        unset($validated['image']);
        $validated['is_active'] = $request->boolean('is_active');

        $bookingPageImage->update($validated);

        return back()->with('success', 'Booking page image updated.');
    }

    public function destroyImage(BookingPageImage $bookingPageImage): RedirectResponse
    {
        ImageStorage::delete($bookingPageImage->image_path);
        $bookingPageImage->delete();

        return back()->with('success', 'Booking page image deleted.');
    }
}
