<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterLink;
use App\Models\FooterSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FooterPageController extends Controller
{
    public function index(): View
    {
        return view('admin.footer-page.index', [
            'footerSetting' => FooterSetting::current(),
            'socialLinks' => FooterLink::query()
                ->where('group', FooterLink::GROUP_SOCIAL)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function updateContent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'brand_name' => ['required', 'string', 'max:120'],
            'tagline' => ['nullable', 'string', 'max:500'],
            'company_section_title' => ['required', 'string', 'max:80'],
            'guest_section_title' => ['required', 'string', 'max:80'],
            'contact_section_title' => ['required', 'string', 'max:80'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:80'],
            'email' => ['nullable', 'string', 'max:120'],
            'copyright_text' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        FooterSetting::current()->update($validated);

        return back()->with('success', 'Footer settings updated.');
    }

    public function storeLink(Request $request): RedirectResponse
    {
        FooterLink::create($this->validatedSocialLink($request));

        return back()->with('success', 'Social link added.');
    }

    public function updateLink(Request $request, FooterLink $footerLink): RedirectResponse
    {
        abort_unless($footerLink->group === FooterLink::GROUP_SOCIAL, 404);

        $footerLink->update($this->validatedSocialLink($request));

        return back()->with('success', 'Social link updated.');
    }

    public function destroyLink(FooterLink $footerLink): RedirectResponse
    {
        abort_unless($footerLink->group === FooterLink::GROUP_SOCIAL, 404);

        $footerLink->delete();

        return back()->with('success', 'Social link deleted.');
    }

    private function validatedSocialLink(Request $request): array
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:120'],
            'url' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:80'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['group'] = FooterLink::GROUP_SOCIAL;
        $validated['sort_order'] = $request->input('sort_order', 0);
        $validated['is_active'] = $request->boolean('is_active', true);

        return $validated;
    }
}
