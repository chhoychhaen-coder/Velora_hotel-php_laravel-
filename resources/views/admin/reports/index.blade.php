@extends('layouts.admin')

@section('title', 'Reports')
@section('page_title', 'Reports')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="mb-1 text-sm font-semibold uppercase text-slate-400">Performance</p>
            <h1 class="mb-0 text-2xl font-bold text-slate-700 sm:text-3xl">Reports</h1>
        </div>

        <form method="GET" action="{{ route('admin.reports') }}" class="grid grid-cols-1 gap-2 rounded-2xl bg-white p-3 shadow-soft-xl sm:grid-cols-[1fr_1fr_auto]">
            <input type="date" name="from" value="{{ $from->format('Y-m-d') }}" class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700">
            <input type="date" name="to" value="{{ $to->format('Y-m-d') }}" class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-slate-700">
            <button type="submit" class="rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 px-4 py-2 text-xs font-bold uppercase text-white shadow-soft-md">Apply</button>
        </form>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
        @foreach([
            ['label' => 'Revenue', 'value' => '$' . number_format($totals['revenue'], 2)],
            ['label' => 'Bookings', 'value' => number_format($totals['bookings'])],
            ['label' => 'Cancelled', 'value' => number_format($totals['cancelled'])],
            ['label' => 'Occupancy', 'value' => $totals['occupancy'] . '%'],
        ] as $card)
            <div class="rounded-2xl bg-white p-5 shadow-soft-xl">
                <p class="mb-1 text-sm font-semibold text-slate-400">{{ $card['label'] }}</p>
                <h3 class="mb-0 text-2xl font-bold text-slate-700">{{ $card['value'] }}</h3>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <div class="rounded-2xl bg-white p-6 shadow-soft-xl">
            <h6 class="mb-4 text-slate-700">Monthly revenue</h6>
            <div class="space-y-3">
                @forelse($monthlyRevenue as $row)
                    @php $width = $totals['revenue'] > 0 ? min(100, ((float) $row->total / (float) $totals['revenue']) * 100) : 0; @endphp
                    <div>
                        <div class="mb-1 flex justify-between text-sm">
                            <span class="font-semibold text-slate-600">{{ $row->month }}</span>
                            <span>${{ number_format($row->total, 2) }}</span>
                        </div>
                        <div class="h-2 rounded bg-slate-100">
                            <div class="h-2 rounded bg-gradient-to-tl from-purple-700 to-pink-500" style="width: {{ $width }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="mb-0 text-sm text-slate-400">No paid revenue in this date range.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-soft-xl">
            <h6 class="mb-4 text-slate-700">Most booked room types</h6>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <tbody>
                        @forelse($roomTypeBookings as $row)
                            <tr>
                                <td class="border-b border-gray-100 py-3 font-semibold text-slate-700">{{ $row->name }}</td>
                                <td class="border-b border-gray-100 py-3 text-right">{{ $row->total }} bookings</td>
                            </tr>
                        @empty
                            <tr><td class="py-3 text-slate-400">No bookings found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-soft-xl">
            <h6 class="mb-4 text-slate-700">Payment methods</h6>
            @forelse($paymentMethods as $row)
                <div class="mb-3 flex items-center justify-between text-sm">
                    <span class="font-semibold capitalize text-slate-600">{{ str_replace('_', ' ', $row->method) }}</span>
                    <span>{{ $row->total }} payments · ${{ number_format($row->amount, 2) }}</span>
                </div>
            @empty
                <p class="mb-0 text-sm text-slate-400">No payments found.</p>
            @endforelse
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-soft-xl">
            <h6 class="mb-4 text-slate-700">Booking status</h6>
            @forelse($statusBreakdown as $row)
                <div class="mb-3 flex items-center justify-between text-sm">
                    <span class="font-semibold capitalize text-slate-600">{{ str_replace('_', ' ', $row->status) }}</span>
                    <span>{{ $row->total }}</span>
                </div>
            @empty
                <p class="mb-0 text-sm text-slate-400">No status data found.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
