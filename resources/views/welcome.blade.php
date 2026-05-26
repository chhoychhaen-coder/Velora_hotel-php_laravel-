@extends('layouts.front')

@section('title', 'Home - Velora Hotel')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('fronend/hotelier-1.0.0/img/carousel-1.jpg') }});">
    <div class="container-fluid page-header-inner py-5">
        <div class="container text-center pb-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Welcome to Velora Hotel</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Welcome</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Booking Start -->
<div class="container-fluid booking pb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <div class="bg-white shadow" style="padding: 35px;">
            <form class="row g-2" method="GET" action="{{ route('booking') }}">
                <div class="col-md-10">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <div class="date" id="date1" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input"
                                    name="check_in" placeholder="Check in" data-target="#date1" data-toggle="datetimepicker" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="date" id="date2" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="check_out" placeholder="Check out" data-target="#date2" data-toggle="datetimepicker"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="adults">
                                <option value="1" selected>Adult 1</option>
                                <option value="1">Adult 1</option>
                                <option value="2">Adult 2</option>
                                <option value="3">Adult 3</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="children">
                                <option value="0" selected>No Child</option>
                                <option value="1">Child 1</option>
                                <option value="2">Child 2</option>
                                <option value="3">Child 3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Booking End -->

<!-- Room Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase">Our Rooms</h6>
            <h1 class="mb-5">Explore Our <span class="text-primary text-uppercase">Rooms</span></h1>
        </div>
        <div class="row g-4">
            @forelse($roomTypes as $roomType)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.{{ $loop->index }}s">
                    <div class="room-item shadow rounded overflow-hidden">
                        <div class="position-relative">
                            <img class="img-fluid" src="{{ asset('fronend/hotelier-1.0.0/img/room-' . (($loop->index % 3) + 1) . '.jpg') }}" alt="{{ $roomType->name }}">
                            <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">${{ number_format($roomType->price_per_night, 2) }}/Night</small>
                        </div>
                        <div class="p-4 mt-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="mb-0">{{ $roomType->name }}</h5>
                                <div class="ps-2">
                                    @for($i = 0; $i < 5; $i++)
                                        <small class="fa fa-star text-primary"></small>
                                    @endfor
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <small class="border-end me-3 pe-3"><i class="fa fa-bed text-primary me-2"></i>{{ $roomType->capacity_adults ?? 2 }} Guests</small>
                                <small><i class="fa fa-wifi text-primary me-2"></i>Wifi</small>
                            </div>
                            <p class="text-body mb-3">{{ $roomType->description ?? 'Experience luxury and comfort in this beautiful room with modern amenities.' }}</p>
                            <div class="d-flex justify-content-between">
                                <a class="btn btn-sm btn-primary rounded py-2 px-4" href="{{ route('rooms') }}">View Detail</a>
                                <a class="btn btn-sm btn-dark rounded py-2 px-4" href="{{ route('booking') }}">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">No rooms available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Room End -->

<!-- Testimonial Start -->
<div class="container-xxl testimonial mt-5 py-5 bg-dark wow zoomIn" data-wow-delay="0.1s" style="margin-bottom: 90px;">
    <div class="container">
        <div class="owl-carousel testimonial-carousel py-5">
            @forelse($testimonials as $testimonial)
                <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                    <p>{{ $testimonial->content }}</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded" src="{{ $testimonial->user->avatar ?? asset('fronend/hotelier-1.0.0/img/testimonial-' . (($loop->index % 3) + 1) . '.jpg') }}" style="width: 45px; height: 45px;">
                        <div class="ps-3">
                            <h6 class="fw-bold mb-1">{{ $testimonial->user->name ?? 'Guest' }}</h6>
                            <small>Guest</small>
                        </div>
                    </div>
                    <i class="fa fa-quote-right fa-3x text-primary position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                </div>
            @empty
                <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                    <p>No testimonials available yet. Be the first to share your experience!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Testimonial End -->

<!-- Newsletter Start -->
<div class="container newsletter mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="row justify-content-center">
        <div class="col-lg-10 border rounded p-1">
            <div class="border rounded text-center p-1">
                <div class="bg-white rounded text-center p-5">
                    <h4 class="mb-4">Subscribe Our <span class="text-primary text-uppercase">Newsletter</span></h4>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control w-100 py-3 ps-4 pe-5" type="text" placeholder="Enter your email">
                        <button type="button" class="btn btn-primary py-2 px-3 position-absolute top-0 end-0 mt-2 me-2">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Newsletter End -->

@endsection
