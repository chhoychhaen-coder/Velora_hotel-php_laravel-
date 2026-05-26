@extends('layouts.front')

@section('title', 'Payment - Velora Hotel')

@section('content')
@php
    $nights = $booking->check_in && $booking->check_out ? $booking->check_in->diffInDays($booking->check_out) : 0;
    $nightlyRate = $nights > 0 ? ((float) $booking->total_price / $nights) : ($booking->room->roomType->price_per_night ?? 0);
    $selectedMethod = old('method', 'credit_card');
    $selectedBankTransferId = (string) old('bank_transfer_id', optional($bankTransfers->first())->id);
@endphp
<x-front-page-header title="Payment" />

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <h6 class="section-title text-start text-primary text-uppercase">Reservation</h6>
                <h1 class="mb-4">Booking Summary</h1>

                <div class="bg-light rounded p-4 summary-panel">
                    <img class="img-fluid rounded w-100 mb-4" src="{{ \App\Helpers\HotelAssets::roomImage($booking->room->roomType->image_url, $booking->room_id) }}" alt="Booked room">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Room</span>
                        <strong>{{ $booking->room->roomType->name ?? 'Room unavailable' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Room Number</span>
                        <strong>{{ $booking->room->room_number ?? 'N/A' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Check In</span>
                        <strong>{{ optional($booking->check_in)->format('M d, Y') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Check Out</span>
                        <strong>{{ optional($booking->check_out)->format('M d, Y') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Guests</span>
                        <strong>{{ $booking->adults }} adults, {{ $booking->children }} children</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Nights</span>
                        <strong>{{ $nights }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Nightly Rate</span>
                        <strong>${{ number_format($nightlyRate, 2) }}</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fs-5">
                        <span>Total</span>
                        <strong class="text-primary">${{ number_format($booking->total_price, 2) }}</strong>
                    </div>
                    <small class="text-muted d-block mt-3">No booking is saved until this payment succeeds. Taxes and extra service fees are not included.</small>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-start text-primary text-uppercase">Pay Now</h6>
                    <h1 class="mb-4">Complete Payment</h1>

                    @if($booking->payment?->status === 'paid')
                        <div class="alert alert-success">
                            This booking has already been paid.
                        </div>
                        <a href="{{ route('bookings.mine') }}" class="btn btn-primary py-3 px-5">View My Bookings</a>
                    @else
                        <form method="POST" action="{{ url()->full() }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="front-payment-methods @error('method') is-invalid @enderror">
                                        @foreach($paymentMethods as $value => $label)
                                            @php
                                                $icon = match ($value) {
                                                    'visa_card' => 'fab fa-cc-visa',
                                                    'mastercard' => 'fab fa-cc-mastercard',
                                                    'bank_transfer' => 'fas fa-university',
                                                    default => 'fas fa-credit-card',
                                                };
                                            @endphp
                                            <label class="front-payment-option">
                                                <input
                                                    type="radio"
                                                    name="method"
                                                    value="{{ $value }}"
                                                    @checked($selectedMethod === $value)
                                                    required
                                                >
                                                <span class="front-payment-card">
                                                    <i class="{{ $icon }}"></i>
                                                    <span>{{ $label }}</span>
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('method')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                                </div>
                                <div class="col-12">
                                    <div class="front-payment-detail-panel" data-payment-panel="card">
                                        <div class="front-payment-panel-heading">
                                            <i class="fas fa-credit-card"></i>
                                            <strong>Card Details</strong>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control @error('card_name') is-invalid @enderror" id="card_name" name="card_name" value="{{ old('card_name') }}" placeholder="Cardholder Name" autocomplete="cc-name">
                                                    <label for="card_name">Cardholder Name</label>
                                                    @error('card_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control @error('card_number') is-invalid @enderror" id="card_number" name="card_number" value="{{ old('card_number') }}" placeholder="Card Number" inputmode="numeric" autocomplete="cc-number">
                                                    <label for="card_number">Card Number</label>
                                                    @error('card_number')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control @error('card_expiry') is-invalid @enderror" id="card_expiry" name="card_expiry" value="{{ old('card_expiry') }}" placeholder="MM/YY" autocomplete="cc-exp">
                                                    <label for="card_expiry">Expiry MM/YY</label>
                                                    @error('card_expiry')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="password" class="form-control @error('card_cvv') is-invalid @enderror" id="card_cvv" name="card_cvv" value="{{ old('card_cvv') }}" placeholder="CVV" inputmode="numeric" autocomplete="cc-csc">
                                                    <label for="card_cvv">CVV</label>
                                                    @error('card_cvv')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="front-payment-detail-panel" data-payment-panel="bank">
                                        <div class="front-payment-panel-heading">
                                            <i class="fas fa-university"></i>
                                            <strong>Bank Transfer Details</strong>
                                        </div>
                                        @if($bankTransfers->isNotEmpty())
                                            <div class="front-bank-methods @error('bank_transfer_id') is-invalid @enderror">
                                                @foreach($bankTransfers as $bank)
                                                    <label class="front-bank-option">
                                                        <input
                                                            type="radio"
                                                            name="bank_transfer_id"
                                                            value="{{ $bank->id }}"
                                                            data-bank-name="{{ $bank->bank_name }}"
                                                            data-account-name="{{ $bank->account_name }}"
                                                            data-account-number="{{ $bank->account_number }}"
                                                            data-qr-url="{{ $bank->qrCodeUrl() }}"
                                                            @checked($selectedBankTransferId === (string) $bank->id)
                                                        >
                                                        <span>{{ $bank->bank_name }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                            @error('bank_transfer_id')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                                            <div class="front-bank-detail-layout">
                                                <div class="front-bank-box">
                                                    <div><span>Bank</span><strong data-bank-preview="name">-</strong></div>
                                                    <div><span>Account Name</span><strong data-bank-preview="account-name">-</strong></div>
                                                    <div><span>Account Number</span><strong data-bank-preview="account-number">-</strong></div>
                                                </div>
                                                <div class="front-bank-qr" data-bank-qr-wrap hidden>
                                                    <span>QR Code</span>
                                                    <img src="" alt="Bank transfer QR code" data-bank-preview="qr">
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-warning">
                                                Bank transfer is not configured yet. Please choose another payment method.
                                            </div>
                                        @endif
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control @error('bank_sender_name') is-invalid @enderror" id="bank_sender_name" name="bank_sender_name" value="{{ old('bank_sender_name') }}" placeholder="Sender Name">
                                                    <label for="bank_sender_name">Sender Name</label>
                                                    @error('bank_sender_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control @error('bank_reference') is-invalid @enderror" id="bank_reference" name="bank_reference" value="{{ old('bank_reference') }}" placeholder="Payout Reference">
                                                    <label for="bank_reference">Payout Reference</label>
                                                    @error('bank_reference')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="receipt" class="form-label fw-bold text-dark">Upload Receipt</label>
                                                <input type="file" class="form-control @error('receipt') is-invalid @enderror" id="receipt" name="receipt" accept="image/jpeg,image/png,application/pdf">
                                                @error('receipt')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Pay ${{ number_format($booking->total_price, 2) }}</button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const methodInputs = document.querySelectorAll('input[name="method"]');
        const cardPanel = document.querySelector('[data-payment-panel="card"]');
        const bankPanel = document.querySelector('[data-payment-panel="bank"]');
        if (!cardPanel || !bankPanel) {
            return;
        }

        const cardFields = cardPanel.querySelectorAll('input');
        const bankFields = bankPanel.querySelectorAll('input');
        const bankMethodInputs = bankPanel.querySelectorAll('input[name="bank_transfer_id"]');
        const bankNamePreview = bankPanel.querySelector('[data-bank-preview="name"]');
        const accountNamePreview = bankPanel.querySelector('[data-bank-preview="account-name"]');
        const accountNumberPreview = bankPanel.querySelector('[data-bank-preview="account-number"]');
        const qrWrap = bankPanel.querySelector('[data-bank-qr-wrap]');
        const qrImage = bankPanel.querySelector('[data-bank-preview="qr"]');

        function syncBankPreview() {
            const selectedBank = bankPanel.querySelector('input[name="bank_transfer_id"]:checked');
            if (!selectedBank) {
                return;
            }

            bankNamePreview.textContent = selectedBank.dataset.bankName || '-';
            accountNamePreview.textContent = selectedBank.dataset.accountName || '-';
            accountNumberPreview.textContent = selectedBank.dataset.accountNumber || '-';

            if (selectedBank.dataset.qrUrl) {
                qrImage.src = selectedBank.dataset.qrUrl;
                qrWrap.hidden = false;
            } else {
                qrImage.removeAttribute('src');
                qrWrap.hidden = true;
            }
        }

        function syncPaymentFields() {
            const selected = document.querySelector('input[name="method"]:checked')?.value || 'credit_card';
            const isBank = selected === 'bank_transfer';

            cardPanel.hidden = isBank;
            bankPanel.hidden = !isBank;
            cardFields.forEach((field) => field.required = !isBank);
            bankFields.forEach((field) => {
                field.required = isBank && field.name !== 'bank_transfer_id';
            });
            bankMethodInputs.forEach((field) => field.required = isBank);
            syncBankPreview();
        }

        methodInputs.forEach((input) => input.addEventListener('change', syncPaymentFields));
        bankMethodInputs.forEach((input) => input.addEventListener('change', syncBankPreview));
        syncPaymentFields();
    });
</script>
@endsection
