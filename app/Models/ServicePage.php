<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePage extends Model
{
    protected $fillable = [
        'section_label',
        'title',
        'title_highlight',
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
            'section_label' => 'Our Services',
            'title' => 'Explore Our',
            'title_highlight' => 'Services',
            'is_active' => true,
        ]);
    }
}
