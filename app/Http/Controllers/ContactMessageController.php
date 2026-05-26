<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(): View
    {
        return view('admin.contact-messages.index', [
            'contactMessages' => ContactMessage::latest('id')->paginate(10),
        ]);
    }
    public function create(): View
{
    return view('admin.contact-messages.create');
}
public function store(Request $request): RedirectResponse
{
    ContactMessage::create($request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'subject' => ['nullable', 'string', 'max:255'],
        'message' => ['required', 'string'],
        'is_read' => ['required', 'boolean'],
    ]));

    return redirect()->route('admin.contact-messages.index')->with('success', 'Message created successfully.');
}

    public function show(ContactMessage $contactMessage): View
    {
        if (! $contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }

        return view('admin.contact-messages.show', [
            'contactMessage' => $contactMessage,
        ]);
    }

    public function update(Request $request, ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->update($request->validate([
            'is_read' => ['required', 'boolean'],
        ]));

        return back()->with('success', 'Message updated successfully.');
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return back()->with('success', 'Message deleted successfully.');
    }
}
