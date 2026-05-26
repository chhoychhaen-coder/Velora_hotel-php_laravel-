<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PaymentSetting extends Model
{
    protected $fillable = [
        'bank_name',
        'account_name',
        'account_number',
        'qr_code_path',
    ];

    public static function current(): self
    {
        return self::query()->firstOrCreate([], [
            'bank_name' => 'Velora Hotel Bank',
            'account_name' => 'Velora Hotel',
            'account_number' => '001-245-8891',
        ]);
    }

    public static function available()
    {
        return self::query()->orderBy('bank_name')->get();
    }

    public function qrCodeUrl(): ?string
    {
        return $this->qr_code_path
            ? Storage::disk('public')->url($this->qr_code_path)
            : null;
    }
}
