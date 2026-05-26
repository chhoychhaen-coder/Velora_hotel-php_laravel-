<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class FooterLink extends Model
{
    public const GROUP_COMPANY = 'company';

    public const GROUP_GUEST = 'guest';

    public const GROUP_SOCIAL = 'social';

    protected $fillable = [
        'group',
        'label',
        'url',
        'route_name',
        'icon',
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

    public function scopeActiveOrdered(Builder $query, string $group): Builder
    {
        return $query
            ->where('group', $group)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function resolvedUrl(): ?string
    {
        if ($this->route_name && Route::has($this->route_name)) {
            return route($this->route_name);
        }

        $link = trim((string) $this->url);

        if ($link === '') {
            return null;
        }

        if (str_starts_with($link, 'http://') || str_starts_with($link, 'https://')) {
            return $link;
        }

        return url('/' . ltrim($link, '/'));
    }

    public function iconClass(): string
    {
        $icon = trim($this->icon ?? 'fa-link');

        if (str_contains($icon, 'fab ') || str_contains($icon, 'fa ')) {
            return $icon;
        }

        if (str_starts_with($icon, 'fa-')) {
            return 'fab ' . $icon;
        }

        return 'fab fa-' . ltrim($icon, 'fa-');
    }
}
