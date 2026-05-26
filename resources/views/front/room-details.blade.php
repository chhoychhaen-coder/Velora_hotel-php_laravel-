@extends('layouts.front')

@section('title', $room->roomType->name . ' - Velora Hotel')

@section('content')
<x-front-page-header
    :title="$room->roomType->name"
    :breadcrumbs="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Rooms', 'url' => route('rooms')],
        ['label' => 'Room ' . $room->room_number, 'active' => true],
    ]"
/>

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-7">
                <img class="img-fluid rounded shadow w-100" src="{{ \App\Helpers\HotelAssets::roomImage($room->roomType->image_url, $room->id) }}" alt="{{ $room->roomType->name }}">
            </div>
            <div class="col-lg-5">
                <h6 class="section-title text-start text-primary text-uppercase">Room Detail</h6>
                <h1 class="mb-3">{{ $room->roomType->name }}</h1>
                <h4 class="text-primary mb-4">${{ number_format($room->roomType->price_per_night, 2) }} <small class="text-muted">/ night</small></h4>

                <div class="d-flex mb-4">
                    <small class="border-end me-3 pe-3"><i class="fa fa-bed text-primary me-2"></i>Room {{ $room->room_number }}</small>
                    <small class="border-end me-3 pe-3"><i class="fa fa-user text-primary me-2"></i>{{ $room->roomType->capacity_adults }} Adults</small>
                    <small><i class="fa fa-child text-primary me-2"></i>{{ $room->roomType->capacity_children }} Children</small>
                </div>

                <p class="mb-4">{{ $room->roomType->description ?? 'A comfortable room prepared with modern amenities for a relaxed stay.' }}</p>

                <div class="bg-light rounded p-4 mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Floor</span>
                        <strong>{{ $room->floor }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Status</span>
                        <span class="badge bg-success">{{ ucfirst($room->status) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Included</span>
                        <strong>Wifi, service, support</strong>
                    </div>
                </div>

                <a href="{{ route('booking', ['room_id' => $room->id]) }}" class="btn btn-primary py-3 px-5">Book This Room</a>
                <a href="{{ route('rooms') }}" class="btn btn-dark py-3 px-5 ms-2">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
