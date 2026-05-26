@props([
    'testimonials',
    'emptyMessage' => 'No testimonials available yet. Be the first to share your experience.',
])

@php
    $carouselId = 'frontTestimonials-' . substr(md5((string) $emptyMessage), 0, 8);
    $count = $testimonials->count();
@endphp

<div class="front-testimonials-wrap">
    @if($count > 0)
        <div
            id="{{ $carouselId }}"
            class="carousel slide front-testimonials-carousel"
            data-bs-ride="carousel"
            data-bs-interval="6000"
            data-bs-pause="hover"
        >
            <div class="carousel-inner">
                @foreach($testimonials as $testimonial)
                    @php $rating = (int) ($testimonial->rating ?? 5); @endphp
                    <div @class(['carousel-item', 'active' => $loop->first])>
                        <article class="front-testimonial-card">
                            <div class="front-testimonial-card__top">
                                <div class="front-testimonial-stars" aria-label="{{ $rating }} out of 5 stars">
                                    @for($i = 0; $i < $rating; $i++)
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    @endfor
                                </div>
                                <span class="front-testimonial-rating">{{ $rating }}/5</span>
                            </div>
                            <blockquote class="front-testimonial-text">“{{ $testimonial->content }}”</blockquote>
                            <footer class="front-testimonial-author">
                                <strong>{{ $testimonial->user->name ?? 'Guest' }}</strong>
                                <span>Verified guest</span>
                            </footer>
                        </article>
                    </div>
                @endforeach
            </div>

            @if($count > 1)
                <div class="front-testimonials-footer">
                    <button class="front-testimonials-arrow" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="prev" aria-label="Previous review">
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    </button>

                    <div class="carousel-indicators front-testimonials-indicators">
                        @foreach($testimonials as $testimonial)
                            <button
                                type="button"
                                data-bs-target="#{{ $carouselId }}"
                                data-bs-slide-to="{{ $loop->index }}"
                                @class(['active' => $loop->first])
                                aria-label="Review {{ $loop->iteration }}"
                            ></button>
                        @endforeach
                    </div>

                    <button class="front-testimonials-arrow" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="next" aria-label="Next review">
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
        </div>
    @else
        <article class="front-testimonial-card front-testimonial-card--empty">
            <p class="mb-0">{{ $emptyMessage }}</p>
        </article>
    @endif
</div>
