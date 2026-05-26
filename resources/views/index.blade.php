@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard')

@section('content')
    <section class="stats-grid">
        <article class="stat-card">
            <span>Total Bookings</span>
            <strong>{{ number_format($stats['bookings'] ?? 0) }}</strong>
            <small>{{ number_format($stats['pending_bookings'] ?? 0) }} pending</small>
        </article>
        <article class="stat-card">
            <span>Available Rooms</span>
            <strong>{{ number_format($stats['available_rooms'] ?? 0) }}</strong>
            <small>{{ number_format($stats['maintenance_rooms'] ?? 0) }} in maintenance</small>
        </article>
        <article class="stat-card">
            <span>Revenue</span>
            <strong>${{ number_format($stats['revenue'] ?? 0, 2) }}</strong>
            <small>Paid payments only</small>
        </article>
        <article class="stat-card">
            <span>Unread Messages</span>
            <strong>{{ number_format($stats['unread_messages'] ?? 0) }}</strong>
            <small>Contact inbox</small>
        </article>
    </section>

    <section class="content-grid">
        <article class="panel wide">
            <div class="panel-header">
                <div>
                    <h2>Recent Bookings</h2>
                    <p>Latest reservation activity</p>
                </div>
                <a href="#" class="button">View all</a>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Guest</th>
                            <th>Room</th>
                            <th>Dates</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentBookings as $booking)
                            <tr>
                                <td>
                                    <strong>{{ $booking->user->name ?? 'Guest' }}</strong>
                                    <small>{{ $booking->user->email ?? 'No email' }}</small>
                                </td>
                                <td>{{ $booking->room->room_number ?? '-' }}</td>
                                <td>
                                    {{ optional($booking->check_in)->format('M d') ?? $booking->check_in }}
                                    -
                                    {{ optional($booking->check_out)->format('M d, Y') ?? $booking->check_out }}
                                </td>
                                <td>${{ number_format($booking->total_price, 2) }}</td>
                                <td><span class="badge {{ $booking->status }}">{{ str_replace('_', ' ', $booking->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty">No bookings yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>

        <article class="panel">
            <div class="panel-header">
                <div>
                    <h2>Room Status</h2>
                    <p>Current inventory</p>
                </div>
            </div>

            <div class="status-list">
                @foreach ($roomStatus as $status => $count)
                    <div class="status-row">
                        <span class="dot {{ $status }}"></span>
                        <span>{{ ucfirst($status) }}</span>
                        <strong>{{ $count }}</strong>
                    </div>
                @endforeach
            </div>
        </article>

        <article class="panel">
            <div class="panel-header">
                <div>
                    <h2>Payments</h2>
                    <p>Latest transactions</p>
                </div>
            </div>

            <div class="stack-list">
                @forelse ($recentPayments as $payment)
                    <div class="stack-item">
                        <div>
                            <strong>${{ number_format($payment->amount, 2) }} {{ $payment->currency }}</strong>
                            <small>{{ str_replace('_', ' ', $payment->method) }}</small>
                        </div>
                        <span class="badge {{ $payment->status }}">{{ $payment->status }}</span>
                    </div>
                @empty
                    <p class="empty">No payments recorded.</p>
                @endforelse
            </div>
        </article>

        <article class="panel">
            <div class="panel-header">
                <div>
                    <h2>Messages</h2>
                    <p>Unread contact requests</p>
                </div>
            </div>

            <div class="stack-list">
                @forelse ($messages as $message)
                    <div class="stack-item align-start">
                        <div>
                            <strong>{{ $message->subject ?: 'No subject' }}</strong>
                            <small>{{ $message->name }} · {{ $message->email }}</small>
                        </div>
                    </div>
                @empty
                    <p class="empty">No unread messages.</p>
                @endforelse
            </div>
        </article>

        <article class="panel">
            <div class="panel-header">
                <div>
                    <h2>Testimonials</h2>
                    <p>Waiting for approval</p>
                </div>
            </div>

            <div class="stack-list">
                @forelse ($testimonials as $testimonial)
                    <div class="stack-item align-start">
                        <div>
                            <strong>{{ $testimonial->user->name ?? 'Guest' }}</strong>
                            <small>{{ $testimonial->rating }}/5 rating</small>
                            <p>{{ Str::limit($testimonial->content, 90) }}</p>
                        </div>
                    </div>
                @empty
                    <p class="empty">No testimonials waiting.</p>
                @endforelse
            </div>
        </article>
    </section>
@endsection
