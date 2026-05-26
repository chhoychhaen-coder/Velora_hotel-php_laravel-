@extends('layouts.front')

@section('title', 'Our Team - Velora Hotel')

@section('content')
<!-- Page Header Start -->
<x-front-page-header title="Our Team" breadcrumb="Team" />
<!-- Page Header End -->

<!-- Team Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase">Our Team</h6>
            <h1 class="mb-5">Meet Our <span class="text-primary text-uppercase">Professional Team</span></h1>
        </div>
        <div class="row g-4">
            @forelse($team as $member)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.{{ $loop->index }}s">
                    <div class="team-item text-center rounded overflow-hidden">
                        <div class="position-relative">
                            <img class="img-fluid" src="{{ \App\Helpers\HotelAssets::url('team-' . (($loop->index % 3) + 1) . '.jpg') }}" alt="{{ $member->name }}">
                            <div class="position-absolute start-50 top-50 translate-middle w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(29, 53, 87, 0.7);">
                                <div class="d-flex">
                                    <a class="btn btn-outline-light btn-social m-1" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-outline-light btn-social m-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-outline-light btn-social m-1" href=""><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h5 class="mb-0">{{ $member->name }}</h5>
                            <small>Hotel Staff</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">No team members available.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Team End -->

@endsection
