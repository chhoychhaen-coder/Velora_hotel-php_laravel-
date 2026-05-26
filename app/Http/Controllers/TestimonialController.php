<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        return view('admin.testimonials.index', [
            'testimonials' => Testimonial::with('user')->latest('id')->paginate(10),
        ]);
    }
public function create(): View
{
    return view('admin.testimonials.create', [
        'users' => User::all(),
    ]);
}
 public function store(Request $request): RedirectResponse
{
    $request->validate([
        'content' => ['required', 'string'],
        'rating' => ['required', 'integer', 'min:1', 'max:5'],
    ]);

    Testimonial::create([
        'user_id' => $request->user()->id,
        'content' => $request->content,
        'rating' => $request->rating, 
        'is_approved' => false,
    ]);

    return redirect()
        ->route('admin.testimonials.index')
        ->with('success', 'Testimonial submitted successfully.');
}

    public function storeCustomer(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'min:10', 'max:1000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        Testimonial::create([
            'user_id' => $request->user()->id,
            'content' => $validated['content'],
            'rating' => $validated['rating'],
            'is_approved' => false,
        ]);

        return back()->with('success', 'Thank you for your review. It will appear after admin approval.');
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update($request->validate([
            'is_approved' => ['required', 'boolean'],
        ]));

        return back()->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return back()->with('success', 'Testimonial deleted successfully.');
    }
}
