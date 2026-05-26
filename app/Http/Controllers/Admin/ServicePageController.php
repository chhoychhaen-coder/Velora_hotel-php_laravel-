<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceItem;
use App\Models\ServicePage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServicePageController extends Controller
{
    public function index(): View
    {
        return view('admin.service-page.index', [
            'servicePage' => ServicePage::current(),
            'serviceItems' => ServiceItem::query()->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function updateContent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'section_label' => ['required', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:255'],
            'title_highlight' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        ServicePage::current()->update($validated);

        return back()->with('success', 'Services page header updated.');
    }

    public function storeItem(Request $request): RedirectResponse
    {
        ServiceItem::create($request->validate([
            'icon' => ['required', 'string', 'max:80'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'sort_order' => $request->input('sort_order', 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Service added.');
    }

    public function updateItem(Request $request, ServiceItem $serviceItem): RedirectResponse
    {
        $serviceItem->update($request->validate([
            'icon' => ['required', 'string', 'max:80'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Service updated.');
    }

    public function destroyItem(ServiceItem $serviceItem): RedirectResponse
    {
        $serviceItem->delete();

        return back()->with('success', 'Service deleted.');
    }
}
