<?php

namespace App\Models;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'guest_name',
        'guest_email',
        'room_id',
        'check_in',
        'check_out',
        'adults',
        'children',
        'special_request',
        'total_price',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
            'adults' => 'integer',
            'children' => 'integer',
            'total_price' => 'decimal:2',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->whereHas('payment', function (Builder $paymentQuery): void {
            $paymentQuery->where('status', 'paid');
        });
    }

    /**
     * Bookings that should block a room on the calendar / availability check.
     */
    public function scopeBlockingAvailability(Builder $query): Builder
    {
        return $query
            ->paid()
            ->where('status', '!=', 'cancelled')
            ->whereIn('status', ['confirmed', 'checked_in', 'checked_out']);
    }

    public function isAwaitingPayment(): bool
    {
        return false;
    }

    public static function cancelStaleUnpaidPending(): int
    {
        return 0;
    }
}
