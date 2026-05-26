@extends('layouts.front')

@section('title', 'Rooms - Velora Hotel')

@section('content')
<!-- Page Header Start -->
<x-front-page-header title="Our Rooms" breadcrumb="Rooms" />
<!-- Page Header End -->

<!-- Room Start -->
<div class="container-xxl py-5">
    <div class="container">


        <div class="row g-4">
            @forelse($rooms as $room)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.{{ $loop->index }}s">
                    <div class="room-item shadow rounded overflow-hidden">
                        <div class="position-relative">
                            <img class="img-fluid" src="{{ \App\Helpers\HotelAssets::roomImage($room->roomType->image_url, $loop->index) }}" alt="{{ $room->roomType->name }}">
                            <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">${{ number_format($room->roomType->price_per_night, 2) }}/Night</small>
                        </div>
                        <div class="p-4 mt-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="mb-0">{{ $room->roomType->name }} - Room {{ $room->room_number }}</h5>
                                <div class="ps-2">
                                    @for($i = 0; $i < 5; $i++)
                                        <small class="fa fa-star text-primary"></small>
                                    @endfor
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <small class="border-end me-3 pe-3"><i class="fa fa-bed text-primary me-2"></i>{{ $room->roomType->capacity_adults ?? 2 }} Guests</small>
                                <small><i class="fa fa-wifi text-primary me-2"></i>Wifi</small>
                            </div>
                            <p class="text-body mb-3">Floor {{ $room->floor }} - {{ ucfirst($room->status) }}</p>
                            <div class="d-flex justify-content-between">
                                <a class="btn btn-sm btn-primary rounded py-2 px-4" href="{{ route('rooms.show', $room) }}">View Detail</a>
                                <a class="btn btn-sm btn-dark rounded py-2 px-4" href="{{ route('booking', array_filter(['room_id' => $room->id, 'check_in' => request('check_in'), 'check_out' => request('check_out')])) }}">Book Now</a>
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

        <!-- Pagination -->
        @if($rooms->hasPages())
            <div class="row mt-5">
                <div class="col-12">
                    {{ $rooms->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
<!-- Room End -->

@endsection
