<?php

namespace Database\Factories;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RoomType>
 */
class RoomTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roomTypes = [
            [
                'name' => 'Standard Room',
                'description' => 'Comfortable room with essential amenities and modern décor',
                'beds' => 1,
                'bathrooms' => 1,
                'price_per_night' => 99.99,
            ],
            [
                'name' => 'Junior Suite',
                'description' => 'Spacious suite with separate sitting area and premium furnishings',
                'beds' => 1,
                'bathrooms' => 1,
                'price_per_night' => 149.99,
            ],
            [
                'name' => 'Executive Suite',
                'description' => 'Luxurious suite with executive amenities and concierge service',
                'beds' => 2,
                'bathrooms' => 2,
                'price_per_night' => 199.99,
            ],
            [
                'name' => 'Super Deluxe',
                'description' => 'Ultra-luxurious suite with premium services and exclusive amenities',
                'beds' => 3,
                'bathrooms' => 2,
                'price_per_night' => 299.99,
            ],
            [
                'name' => 'Family Room',
                'description' => 'Spacious family accommodation with multiple beds and amenities for children',
                'beds' => 3,
                'bathrooms' => 2,
                'price_per_night' => 249.99,
            ],
        ];

        $type = $roomTypes[$this->faker->numberBetween(0, 4)];

        return [
            'name' => $type['name'],
            'description' => $type['description'],
            'beds' => $type['beds'],
            'bathrooms' => $type['bathrooms'],
            'price_per_night' => $type['price_per_night'],
            'is_active' => true,
        ];
    }
}
            //
