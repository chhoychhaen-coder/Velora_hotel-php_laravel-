@extends('layouts.front')

@section('title', 'About Us - Velora Hotel')

@section('content')
<x-front-page-header title="About Us" breadcrumb="About" />

<div class="container-xxl py-5">
    <div class="container">
        @if($aboutPage)
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <h6 class="section-title text-start text-primary text-uppercase">{{ $aboutPage->section_label }}</h6>
                    <h1 class="mb-4">{{ $aboutPage->title }} <span class="text-primary">{{ $aboutPage->title_highlight }}</span></h1>
                    @if($aboutPage->paragraph_one)
                        <p class="mb-4">{{ $aboutPage->paragraph_one }}</p>
                    @endif
                    @if($aboutPage->paragraph_two)
                        <p class="mb-4">{{ $aboutPage->paragraph_two }}</p>
                    @endif

                    @foreach($aboutFeatures as $feature)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0 bg-primary rounded-circle p-3 me-3">
                                <i class="fa fa-check text-white"></i>
                            </div>
                            <h6 class="mb-0">{{ $feature->title }}</h6>
                        </div>
                    @endforeach

                    <a class="btn btn-primary py-3 px-5 mt-3" href="{{ $aboutPage->buttonUrl() }}">{{ $aboutPage->button_label }}</a>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3">
                        @forelse($aboutGalleryImages as $image)
                            <div class="col-6 {{ $image->align_class }}">
                                <img
                                    class="img-fluid rounded {{ $image->size_class }}"
                                    src="{{ $image->imageUrl() }}"
                                    alt=""
                                    @if($image->extra_style) style="{{ $image->extra_style }}" @endif
                                    loading="lazy"
                                >
                            </div>
                        @empty
                            @for($i = 1; $i <= 4; $i++)
                                <div class="col-6 {{ $i % 2 === 1 ? 'text-end' : 'text-start' }}">
                                    <img class="img-fluid rounded {{ $i === 3 ? 'w-50' : ($i === 1 || $i === 4 ? 'w-75' : 'w-100') }}" src="{{ \App\Helpers\HotelAssets::url('about-' . $i . '.jpg') }}" alt="" @if($i === 1) style="margin-top: 25%;" @endif loading="lazy">
                                </div>
                            @endfor
                        @endforelse
                    </div>
                </div>
            </div>
        @else
            <p class="text-center text-muted py-5">About page content is currently unavailable.</p>
        @endif
    </div>
</div>
@endsection
