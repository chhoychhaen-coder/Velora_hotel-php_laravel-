<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInfoItem;
use App\Models\ContactPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactPageController extends Controller
{
    public function index(): View
    {
        return view('admin.contact-page.index', [
            'contactPage' => ContactPage::current(),
            'contactInfoItems' => ContactInfoItem::query()->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function updateContent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'section_label' => ['required', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:255'],
            'title_highlight' => ['required', 'string', 'max:255'],
            'map_embed_url' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $normalizedMap = ContactPage::normalizeMapEmbedUrl($validated['map_embed_url'] ?? null);

        if (filled($validated['map_embed_url'] ?? null) && $normalizedMap === null) {
            return back()
                ->withInput()
                ->withErrors([
                    'map_embed_url' => 'Use the Google Maps embed link (Share → Embed a map → copy iframe src), not a short or share link.',
                ]);
        }

        $validated['map_embed_url'] = $normalizedMap;

        ContactPage::current()->update($validated);

        return back()->with('success', 'Contact page content updated.');
    }

    public function storeItem(Request $request): RedirectResponse
    {
        ContactInfoItem::create($request->validate([
            'title' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'sort_order' => $request->input('sort_order', 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Contact info added.');
    }

    public function updateItem(Request $request, ContactInfoItem $contactInfoItem): RedirectResponse
    {
        $contactInfoItem->update($request->validate([
            'title' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Contact info updated.');
    }

    public function destroyItem(ContactInfoItem $contactInfoItem): RedirectResponse
    {
        $contactInfoItem->delete();

        return back()->with('success', 'Contact info deleted.');
    }
}
