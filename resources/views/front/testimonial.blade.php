@extends('layouts.front')

@section('title', 'Testimonials - Velora Hotel')

@section('content')
<x-front-page-header title="Testimonials" wrapper-class="mb-0" />

<section class="front-testimonials-page">
    <div class="container">
        <header class="front-testimonials-page__intro">
            <span class="front-mini-label">Guest Reviews</span>
            <h2>What our guests say</h2>
            <p>Real feedback from verified stays. Share yours after your visit.</p>
        </header>

        <div class="row g-4 g-xl-5 align-items-start">
            <div class="col-lg-4">
                <div class="front-home-review-panel">
                    <span class="front-mini-label">Write a review</span>
                    <h3>Share your experience</h3>
                    <p>Your review is published after admin approval.</p>

                    @auth
                        <form method="POST" action="{{ route('testimonials.store') }}" class="front-home-review-form">
                            @csrf
                            <div>
                                <label for="rating" class="form-label">Rating</label>
                                <select id="rating" name="rating" class="form-select @error('rating') is-invalid @enderror" required>
                                    @for($rating = 5; $rating >= 1; $rating--)
                                        <option value="{{ $rating }}" @selected(old('rating', 5) == $rating)>
                                            {{ $rating }} star{{ $rating > 1 ? 's' : '' }}
                                        </option>
                                    @endfor
                                </select>
                                @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="content" class="form-label">Your review</label>
                                <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="4" placeholder="Tell us about your stay..." required>{{ old('content') }}</textarea>
                                @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Submit Review</button>
                        </form>
                    @else
                        <div class="front-home-login-box">
                            <span>Sign in to write a review</span>
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
                        </div>
                    @endauth
                </div>
            </div>

            <div class="col-lg-8">
                <x-front-testimonial-carousel :testimonials="$testimonials" />
            </div>
        </div>
    </div>
</section>
@endsection
