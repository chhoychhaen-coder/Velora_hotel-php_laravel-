@extends('layouts.front')

@section('title', 'Booking Details - Velora Hotel')

@section('content')
<x-front-page-header
    title="Booking Details"
    :breadcrumbs="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'My Bookings', 'url' => route('bookings.mine')],
        ['label' => 'Details', 'active' => true],
    ]"
/>

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="shadow rounded p-4 bg-white mb-4">
                    <h2 class="mb-3">Reservation information</h2>

                    <div class="row mb-3">
                        <div class="col-sm-6 mb-3">
                            <strong>Room</strong>
                            <div>{{ $booking->room->roomType->name ?? 'Room unavailable' }}</div>
                            <small class="text-muted">Room {{ $booking->room->room_number ?? 'N/A' }}</small>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <strong>Status</strong>
                            <div>{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <strong>Check-in</strong>
                            <div>{{ optional($booking->check_in)->format('M d, Y') ?? 'N/A' }}</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <strong>Check-out</strong>
                            <div>{{ optional($booking->check_out)->format('M d, Y') ?? 'N/A' }}</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <strong>Guests</strong>
                            <div>{{ $booking->adults }} adult{{ $booking->adults === 1 ? '' : 's' }}, {{ $booking->children }} child{{ $booking->children === 1 ? '' : 'ren' }}</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <strong>Total Price</strong>
                            <div>${{ number_format($booking->total_price ?? 0, 2) }}</div>
                        </div>
                        <div class="col-12 mb-3">
                            <strong>Special request</strong>
                            <div>{{ $booking->special_request ?: 'None' }}</div>
                        </div>
                    </div>
                </div>

                <div class="shadow rounded p-4 bg-white">
                    <h2 class="mb-3">Payment status</h2>

                    <div class="mb-3">
                        <strong>Payment method</strong>
                        <div>{{ $booking->payment?->method ? ucfirst(str_replace('_', ' ', $booking->payment->method)) : 'Not chosen' }}</div>
                    </div>
                    <div class="mb-3">
                        <strong>Payment status</strong>
                        <div>
                            <span class="badge bg-success">Paid</span>
                        </div>
                    </div>
                    @if($booking->payment && $booking->payment->receipt_path)
                        <div class="mb-3">
                            <strong>Receipt</strong>
                            <div><a href="{{ asset('storage/' . $booking->payment->receipt_path) }}" target="_blank">View uploaded receipt</a></div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="shadow rounded p-4 bg-white mb-4">
                    <h2 class="mb-3">Customer</h2>
                    <div class="mb-2"><strong>Name</strong></div>
                    <div>{{ $booking->guest_name ?? $booking->user->name }}</div>
                    <div class="mb-2 mt-3"><strong>Email</strong></div>
                    <div>{{ $booking->guest_email ?? $booking->user->email }}</div>
                </div>

                <div class="shadow rounded p-4 bg-white">
                    <h2 class="mb-3">Actions</h2>
                    <a href="{{ route('bookings.mine') }}" class="btn btn-outline-primary w-100 mb-3">Back to My Bookings</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
