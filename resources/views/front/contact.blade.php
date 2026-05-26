@extends('layouts.front')

@section('title', 'Contact Us - Velora Hotel')

@section('content')
<!-- Page Header Start -->
<x-front-page-header title="Contact Us" breadcrumb="Contact" />
<!-- Page Header End -->

<!-- Contact Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            @if($contactPage)
                <h6 class="section-title text-center text-primary text-uppercase">{{ $contactPage->section_label }}</h6>
                <h1 class="mb-5"><span class="text-primary text-uppercase">{{ $contactPage->title }}</span> {{ $contactPage->title_highlight }}</h1>
            @else
                <h6 class="section-title text-center text-primary text-uppercase">Contact Us</h6>
                <h1 class="mb-5"><span class="text-primary text-uppercase">Contact</span> For Any Query</h1>
            @endif
        </div>
        <div class="row g-4">
            <div class="col-12">
                <div class="row gy-4">
                    @forelse($contactInfoItems as $item)
                        <div class="col-md-4">
                            <h6 class="section-title text-start text-primary text-uppercase">{{ $item->title }}</h6>
                            <p><i class="fa fa-envelope-open text-primary me-2"></i>{{ $item->email }}</p>
                        </div>
                    @empty
                        <div class="col-md-4">
                            <h6 class="section-title text-start text-primary text-uppercase">Booking</h6>
                            <p><i class="fa fa-envelope-open text-primary me-2"></i>book@velorahotel.com</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="section-title text-start text-primary text-uppercase">General</h6>
                            <p><i class="fa fa-envelope-open text-primary me-2"></i>info@velorahotel.com</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="section-title text-start text-primary text-uppercase">Technical</h6>
                            <p><i class="fa fa-envelope-open text-primary me-2"></i>tech@velorahotel.com</p>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="col-md-6 wow fadeIn" data-wow-delay="0.1s">
                <iframe class="position-relative rounded w-100 h-100"
                    src="{{ $mapEmbedUrl }}"
                    frameborder="0" style="min-height: 350px; border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                    tabindex="0" title="Hotel location map"></iframe>
            </div>
            <div class="col-md-6">
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Your Name" value="{{ old('name', auth()->user()->name ?? '') }}">
                                    <label for="name">Your Name</label>
                                    @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Your Email" value="{{ old('email', auth()->user()->email ?? '') }}">
                                    <label for="email">Your Email</label>
                                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="Subject" value="{{ old('subject') }}">
                                    <label for="subject">Subject</label>
                                    @error('subject')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control @error('message') is-invalid @enderror" placeholder="Leave a message here" id="message" name="message" style="height: 150px">{{ old('message') }}</textarea>
                                    <label for="message">Message</label>
                                    @error('message')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

@endsection
