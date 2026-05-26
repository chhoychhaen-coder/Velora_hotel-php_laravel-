<?php

namespace App\Models;

use App\Helpers\HotelAssets;
use App\Helpers\ImageStorage;
use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'kicker',
        'title',
        'body',
        'image_path',
        'primary_button_label',
        'primary_button_link',
        'secondary_button_label',
        'secondary_button_link',
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

    public function imageUrl(string $fallback = 'hero.jpg'): string
    {
        if ($this->image_path) {
            return ImageStorage::url($this->image_path) ?? HotelAssets::url($fallback);
        }

        return HotelAssets::url($fallback);
    }

    public function buttonUrl(?string $link): string
    {
        if (! $link) {
            return '#';
        }

        if (str_starts_with($link, 'http://') || str_starts_with($link, 'https://')) {
            return $link;
        }

        return url('/' . ltrim($link, '/'));
    }

    public static function activeOrdered()
    {
        return static::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /** Image URLs from active slides for inner-page banners (images only). */
    public static function bannerImageUrls(): \Illuminate\Support\Collection
    {
        $urls = static::activeOrdered()
            ->get()
            ->map(fn (self $slide) => $slide->imageUrl('carousel-2.jpg'))
            ->unique()
            ->values();

        if ($urls->isNotEmpty()) {
            return $urls;
        }

        return collect([HotelAssets::url('carousel-2.jpg')]);
    }
}
