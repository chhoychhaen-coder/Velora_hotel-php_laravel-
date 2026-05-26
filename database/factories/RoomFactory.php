<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_type_id' => RoomType::factory(),
            'room_number' => $this->faker->unique()->numerify('###'),
            'floor' => $this->faker->numberBetween(1, 5),
            'status' => $this->faker->randomElement(['available', 'occupied', 'maintenance']),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }

    public function available(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'available',
        ]);
    }
}
            //

