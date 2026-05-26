<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = [
        'brand_name',
        'tagline',
        'company_section_title',
        'guest_section_title',
        'contact_section_title',
        'address',
        'phone',
        'email',
        'copyright_text',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'brand_name' => 'Velora Hotel',
            'tagline' => 'Comfortable rooms, simple booking, and responsive service for every guest.',
            'company_section_title' => 'Company',
            'guest_section_title' => 'Guest',
            'contact_section_title' => 'Contact',
            'address' => '123 Street, New York, USA',
            'phone' => '+012 345 67890',
            'email' => 'info@velorahotel.com',
            'copyright_text' => 'Velora Hotel. All rights reserved.',
            'is_active' => true,
        ]);
    }
}
