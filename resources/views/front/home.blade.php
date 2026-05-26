@extends('layouts.front')

@section('title', 'Home - Velora Hotel')

@section('content')
@php
    use App\Helpers\HotelAssets;
    $hasSlides = $heroSlides->isNotEmpty();
    $carouselId = 'homeHeroCarousel';
@endphp

<section class="front-home-hero-slider">
    @if($hasSlides && $heroSlides->count() > 1)
        <div
            id="{{ $carouselId }}"
            class="carousel slide carousel-fade front-home-hero-carousel"
            data-bs-ride="carousel"
            data-bs-interval="6000"
            data-bs-pause="hover"
        >
            <div class="carousel-indicators front-home-hero-indicators">
                @foreach($heroSlides as $slide)
                    <button
                        type="button"
                        data-bs-target="#{{ $carouselId }}"
                        data-bs-slide-to="{{ $loop->index }}"
                        @class(['active' => $loop->first])
                        aria-label="Slide {{ $loop->iteration }}"
                    ></button>
                @endforeach
            </div>

            <div class="carousel-inner">
                @foreach($heroSlides as $slide)
                    <div @class(['carousel-item', 'active' => $loop->first])>
                        <div class="front-home-hero" style="background-image: url('{{ $slide->imageUrl() }}');">
                            <div class="front-home-hero__overlay">
                                <div class="container">
                                    <div class="front-home-hero__content">
                                        @if($slide->kicker)
                                            <span class="front-hero-kicker">{{ $slide->kicker }}</span>
                                        @endif
                                        <h1>{{ $slide->title }}</h1>
                                        @if($slide->body)
                                            <p>{{ $slide->body }}</p>
                                        @endif
                                        <div class="front-hero-actions">
                                            <a href="{{ $slide->buttonUrl($slide->primary_button_link) }}" class="btn btn-primary">{{ $slide->primary_button_label }}</a>
                                            @if($slide->secondary_button_label && $slide->secondary_button_link)
                                                <a href="{{ $slide->buttonUrl($slide->secondary_button_link) }}" class="btn btn-outline-light">{{ $slide->secondary_button_label }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev front-home-hero-control" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="prev" aria-label="Previous slide">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </button>
            <button class="carousel-control-next front-home-hero-control" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="next" aria-label="Next slide">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </button>
        </div>
    @elseif($hasSlides)
        @php $slide = $heroSlides->first(); @endphp
        <div class="front-home-hero" style="background-image: url('{{ $slide->imageUrl() }}');">
            <div class="front-home-hero__overlay">
                <div class="container">
                    <div class="front-home-hero__content">
                        @if($slide->kicker)
                            <span class="front-hero-kicker">{{ $slide->kicker }}</span>
                        @endif
                        <h1>{{ $slide->title }}</h1>
                        @if($slide->body)
                            <p>{{ $slide->body }}</p>
                        @endif
                        <div class="front-hero-actions">
                            <a href="{{ $slide->buttonUrl($slide->primary_button_link) }}" class="btn btn-primary">{{ $slide->primary_button_label }}</a>
                            @if($slide->secondary_button_label && $slide->secondary_button_link)
                                <a href="{{ $slide->buttonUrl($slide->secondary_button_link) }}" class="btn btn-outline-light">{{ $slide->secondary_button_label }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="front-home-hero" style="background-image: url('{{ HotelAssets::url('hero.jpg') }}');">
            <div class="front-home-hero__overlay">
                <div class="container">
                    <div class="front-home-hero__content">
                        <span class="front-hero-kicker">Velora Hotel</span>
                        <h1>Comfortable stays, made simple</h1>
                        <p>Browse rooms, book online, and enjoy a calm modern stay from check-in to check-out.</p>
                        <div class="front-hero-actions">
                            <a href="{{ route('rooms') }}" class="btn btn-primary">Explore Rooms</a>
                            <a href="{{ route('booking') }}" class="btn btn-outline-light">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>

<section class="front-home-features">
    <div class="container">
        <div class="row g-3">
            <div class="col-6 col-lg-3">
                <div class="front-home-feature">
                    <i class="fa fa-bed" aria-hidden="true"></i>
                    <div>
                        <strong>Comfortable Rooms</strong>
                        <span>Clean spaces with modern amenities</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="front-home-feature">
                    <i class="fa fa-wifi" aria-hidden="true"></i>
                    <div>
                        <strong>Free WiFi</strong>
                        <span>Stay connected throughout your visit</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="front-home-feature">
                    <i class="fa fa-calendar-check" aria-hidden="true"></i>
                    <div>
                        <strong>Easy Booking</strong>
                        <span>Reserve your room in a few steps</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="front-home-feature">
                    <i class="fa fa-concierge-bell" aria-hidden="true"></i>
                    <div>
                        <strong>Friendly Service</strong>
                        <span>Helpful staff whenever you need them</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="front-home-section">
    <div class="container">
        <header class="front-home-section__head text-center">
            <span class="front-mini-label">Our Rooms</span>
            <h2>Find your perfect stay</h2>
            <p>Clear pricing, room details, and fast online booking for every guest.</p>
        </header>

        <div class="row g-4">
            @forelse($rooms as $room)
                <div class="col-md-6 col-lg-4">
                    <article class="front-home-room">
                        <a href="{{ route('rooms.show', $room) }}" class="front-home-room__media">
                            <img src="{{ HotelAssets::roomImage($room->roomType->image_url, $loop->index) }}" alt="{{ $room->roomType->name }}">
                            <span class="front-home-room__price">${{ number_format($room->roomType->price_per_night, 0) }}<small>/night</small></span>
                        </a>
                        <div class="front-home-room__body">
                            <div class="front-home-room__top">
                                <h3><a href="{{ route('rooms.show', $room) }}">{{ $room->roomType->name }}</a></h3>
                                <span class="front-home-room__number">#{{ $room->room_number }}</span>
                            </div>
                            <ul class="front-home-room__meta">
                                <li><i class="fa fa-user-friends" aria-hidden="true"></i>{{ $room->roomType->capacity_adults ?? 2 }} guests</li>
                                <li><i class="fa fa-wifi" aria-hidden="true"></i>WiFi</li>
                                <li><i class="fa fa-layer-group" aria-hidden="true"></i>Floor {{ $room->floor }}</li>
                            </ul>
                            <p>{{ Str::limit($room->roomType->description ?? 'A comfortable room with modern amenities.', 90) }}</p>
                            <div class="front-home-room__actions">
                                <a href="{{ route('rooms.show', $room) }}" class="btn btn-sm btn-outline-dark">Details</a>
                                <a href="{{ route('booking', ['room_id' => $room->id]) }}" class="btn btn-sm btn-primary">Book</a>
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="front-home-empty">No rooms available right now. Please check back soon.</div>
                </div>
            @endforelse
        </div>

        @if($rooms->isNotEmpty())
            <div class="text-center mt-5">
                <a href="{{ route('rooms') }}" class="btn btn-primary px-4">View All Rooms</a>
            </div>
        @endif
    </div>
</section>

<section class="front-home-section front-home-section--muted">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-4">
                <div class="front-home-review-panel">
                    <span class="front-mini-label">Guest Reviews</span>
                    <h2>Share your stay</h2>
                    <p>Help future guests with your feedback. Reviews show after approval.</p>

                    @auth
                        <form method="POST" action="{{ route('testimonials.store') }}" class="front-home-review-form">
                            @csrf
                            <div>
                                <label for="home_rating" class="form-label">Rating</label>
                                <select id="home_rating" name="rating" class="form-select @error('rating') is-invalid @enderror" required>
                                    @for($rating = 5; $rating >= 1; $rating--)
                                        <option value="{{ $rating }}" @selected(old('rating', 5) == $rating)>{{ $rating }} stars</option>
                                    @endfor
                                </select>
                                @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="home_content" class="form-label">Your review</label>
                                <textarea id="home_content" name="content" class="form-control @error('content') is-invalid @enderror" rows="4" placeholder="How was your stay?" required>{{ old('content') }}</textarea>
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
                <header class="front-home-section__head mb-4">
                    <span class="front-mini-label">Testimonials</span>
                    <h2>What our guests say</h2>
                </header>

                <x-front-testimonial-carousel
                    :testimonials="$testimonials"
                    empty-message="No reviews yet. Be the first to share your experience."
                />

                @if($testimonials->isNotEmpty())
                    <p class="mt-4 mb-0">
                        <a href="{{ route('testimonial') }}" class="front-home-link">Read all testimonials <i class="fa fa-arrow-right ms-1" aria-hidden="true"></i></a>
                    </p>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="front-home-cta">
    <div class="container">
        <div class="front-home-cta__inner">
            <div>
                <h2>Ready to book?</h2>
                <p>Pick a room, choose your dates, and confirm your reservation in minutes.</p>
            </div>
            <a href="{{ route('booking') }}" class="btn btn-primary btn-lg px-4">Book Now</a>
        </div>
    </div>
</section>
@endsection
