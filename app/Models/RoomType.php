<?php

namespace App\Models;

use App\Helpers\ImageStorage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'capacity_adults',
        'capacity_children',
        'price_per_night',
        'image_url',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'capacity_adults' => 'integer',
            'capacity_children' => 'integer',
            'price_per_night' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    protected function displayImageUrl(): Attribute
    {
        return Attribute::get(fn () => ImageStorage::url($this->image_url));
    }
}
