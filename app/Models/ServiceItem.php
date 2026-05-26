<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    protected $fillable = [
        'icon',
        'title',
        'description',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public static function activeOrdered()
    {
        return static::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function iconClass(): string
    {
        $icon = trim($this->icon ?? 'fa-star');

        if (str_contains($icon, 'fa ')) {
            return $icon;
        }

        if (str_starts_with($icon, 'fa-')) {
            return 'fa ' . $icon;
        }

        return 'fa fa-' . ltrim($icon, 'fa-');
    }
}
