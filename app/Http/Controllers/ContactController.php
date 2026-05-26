<?php

namespace App\Http\Controllers;

use App\Models\ContactInfoItem;
use App\Models\ContactMessage;
use App\Models\ContactPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        $contactPage = ContactPage::current();

        return view('front.contact', [
            'contactPage' => $contactPage->is_active ? $contactPage : null,
            'mapEmbedUrl' => $contactPage->mapUrl(),
            'contactInfoItems' => ContactInfoItem::activeOrdered()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        ContactMessage::create($validated);

        return redirect()->route('contact')->with('success', 'Message sent successfully. We will get back to you soon!');
    }
}
