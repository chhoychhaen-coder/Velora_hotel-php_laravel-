@extends('layouts.front')

@section('title', 'My Bookings - Velora Hotel')

@section('content')
<x-front-page-header title="My Bookings" />

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase">Booking History</h6>
            <h1 class="mb-5">Your <span class="text-primary text-uppercase">Reservations</span></h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive shadow">
            <table class="table table-hover align-middle mb-0 bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>Room</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Guests</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Request</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        @php
                            $statusClass = match($booking->status) {
                                'confirmed' => 'bg-primary',
                                'cancelled' => 'bg-danger',
                                'checked_in' => 'bg-success',
                                'checked_out' => 'bg-secondary',
                                default => 'bg-warning text-dark',
                            };
                        @endphp
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $booking->room->roomType->name ?? 'Room unavailable' }}</div>
                                <small class="text-muted">Room {{ $booking->room->room_number ?? 'N/A' }}</small>
                            </td>
                            <td>{{ optional($booking->check_in)->format('M d, Y') ?? 'N/A' }}</td>
                            <td>{{ optional($booking->check_out)->format('M d, Y') ?? 'N/A' }}</td>
                            <td>{{ $booking->adults }} adult{{ $booking->adults === 1 ? '' : 's' }}, {{ $booking->children }} child{{ $booking->children === 1 ? '' : 'ren' }}</td>
                            <td>${{ number_format($booking->total_price ?? 0, 2) }}</td>
                            <td>
                                <span class="badge bg-success">Paid</span>
                            </td>
                            <td>
                                <span class="badge {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</span>
                            </td>
                            <td class="text-muted">{{ $booking->special_request ?: 'None' }}</td>
                            <td>
                                <a href="{{ route('bookings.mine.show', $booking) }}" class="btn btn-sm btn-outline-primary mb-1">Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <h5 class="mb-2">No bookings yet</h5>
                                <p class="text-muted mb-4">Your reservations will appear here after you book a room.</p>
                                <a href="{{ route('booking') }}" class="btn btn-primary py-2 px-4">Book Now</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
            <div class="mt-4">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
