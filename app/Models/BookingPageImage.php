<?php

namespace App\Models;

use App\Helpers\HotelAssets;
use App\Helpers\ImageStorage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BookingPageImage extends Model
{
    protected $fillable = [
        'image_path',
        'size_class',
        'align_class',
        'extra_style',
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

    public function imageUrl(string $fallback = 'about-1.jpg'): string
    {
        if ($this->image_path) {
            return ImageStorage::url($this->image_path) ?? HotelAssets::url($fallback);
        }

        return HotelAssets::url('about-' . (($this->sort_order % 4) + 1) . '.jpg');
    }

    public function scopeActiveOrdered(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
