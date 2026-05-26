@extends('layouts.admin')

@section('title', 'Payments')
@section('page_title', 'Payments')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6 p-4 rounded">
        <h1 class="text-3xl font-bold text-gray-800">Payments</h1>

        <a href="{{ route('admin.payments.create') }}"
           class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
            Create Payment
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Currency</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>


                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payments as $payment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $payment->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->booking_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($payment->amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->currency }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $payment->method)) }}</td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i') : 'N/A' }}</td>
<td class="px-6 py-4 whitespace-nowrap text-sm">

    <div class="flex items-center gap-3">

        {{-- UPDATE STATUS --}}
        <form method="POST"
              action="{{ route('admin.payments.update', $payment) }}"
              class="flex items-center gap-2">

            @csrf
            @method('PATCH')

           

        </form>

        {{-- DELETE --}}
        <form method="POST"
              action="{{ route('admin.payments.destroy', $payment) }}"
              onsubmit="return confirm('Delete this payment?')">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="flex items-center gap-1 px-3 py-1 text-sm bg-red-600 hover:bg-red-700 text-white rounded-md transition">

                <!-- trash icon -->
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-4 w-4"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />

                </svg>

                Delete
            </button>

        </form>

    </div>

</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="px-6 py-4 text-center text-gray-500">No payments found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($payments->hasPages())
    <div class="mt-6">
        {{ $payments->links() }}
    </div>
    @endif
</div>
@endsection
