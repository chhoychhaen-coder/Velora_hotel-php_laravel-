<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    public $timestamps = false;

    public const METHODS = [
        'credit_card' => 'Credit Card',
        'visa_card' => 'Visa Card',
        'mastercard' => 'Mastercard',
        'bank_transfer' => 'Bank Transfer',
    ];

    protected $fillable = [
        'booking_id',
        'amount',
        'currency',
        'method',
        'payment_setting_id',
        'bank_transfer_id',
        'transaction_id',
        'receipt_path',
        'bank_sender_name',
        'bank_reference',
        'status',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function paymentSetting(): BelongsTo
    {
        return $this->belongsTo(PaymentSetting::class);
    }

    public function bankTransfer(): BelongsTo
    {
        return $this->belongsTo(BankTransfer::class);
    }
}
