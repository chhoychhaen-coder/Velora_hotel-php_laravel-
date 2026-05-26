@extends('layouts.admin')

@section('title', 'Create Payment')
@section('page_title', 'Create Payment')

@section('content')
<div class="container mx-auto px-4 py-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Create Payment</h1>

        <a href="{{ route('admin.payments.index') }}"
           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">

        <form action="{{ route('admin.payments.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Booking -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Booking</label>
                <select name="booking_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Select Booking</option>
                    @foreach($bookings as $booking)
                        <option value="{{ $booking->id }}">
                            #{{ $booking->id }} - {{ $booking->user->name ?? 'User' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Amount -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="number" step="0.01" name="amount"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                       required>
            </div>

            <!-- Currency -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Currency</label>
                <input type="text" name="currency" value="USD"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                       required>
            </div>

            <!-- Method -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Method</label>
                <select name="method" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @foreach($paymentMethods as $value => $label)
                        <option value="{{ $value }}" @selected(old('method') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Transaction ID -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Transaction ID (optional)</label>
                <input type="text" name="transaction_id"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="paid">Paid</option>
                </select>
            </div>

            <!-- Paid At -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Paid At (optional)</label>
                <input type="datetime-local" name="paid_at"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Submit -->
            <div class="pt-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded">
                    Create Payment
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
