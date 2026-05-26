<?php

namespace Database\Factories;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $testimonials = [
            'The service was outstanding! Every detail was perfect. The rooms are beautifully designed and the staff is incredibly attentive.',
            'A wonderful experience from check-in to check-out. Highly recommend this hotel for anyone looking for luxury and comfort.',
            'The facilities are world-class and the location is perfect. Will definitely book again for our next vacation.',
            'Exceptional service and attention to detail. The best hotel experience we\'ve had in years.',
            'Amazing view, comfortable beds, and friendly staff. Everything we could ask for in a hotel.',
            'Five-star experience at every touchpoint. From the food to the amenities, everything was perfect.',
        ];

        return [
            'user_id' => User::factory(),
            'content' => $this->faker->randomElement($testimonials),
            'rating' => $this->faker->numberBetween(4, 5),
            'is_approved' => true,
        ];
    }

    public function approved(): self
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => true,
        ]);
    }

    public function pending(): self
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => false,
        ]);
    }
}
            //

