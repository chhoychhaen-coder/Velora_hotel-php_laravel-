@extends('layouts.front')

@section('title', 'Services - Velora Hotel')

@section('content')
<x-front-page-header title="Our Services" breadcrumb="Services" />

<div class="container-xxl py-5">
    <div class="container">
        @if($servicePage)
            <div class="text-center">
                <h6 class="section-title text-center text-primary text-uppercase">{{ $servicePage->section_label }}</h6>
                <h1 class="mb-5">{{ $servicePage->title }} <span class="text-primary text-uppercase">{{ $servicePage->title_highlight }}</span></h1>
            </div>
            <div class="row g-4">
                @forelse($serviceItems as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="service-item rounded pt-3 h-100">
                            <div class="p-4">
                                <i class="{{ $item->iconClass() }} fa-3x text-primary mb-4" aria-hidden="true"></i>
                                <h5>{{ $item->title }}</h5>
                                @if($item->description)
                                    <p class="mb-0">{{ $item->description }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted py-4">No services available at the moment.</p>
                    </div>
                @endforelse
            </div>
        @else
            <p class="text-center text-muted py-5">Services page is currently unavailable.</p>
        @endif
    </div>
</div>
@endsection
