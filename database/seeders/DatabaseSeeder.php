<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin users
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'admin',
                'phone' => null,
            ],
        );

        User::updateOrCreate([
            'email' => 'chhean@example.com',
        ], [
            'name' => 'Chhean',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'admin',
            'phone' => null,
        ]);

        // Create receptionist users
        User::factory(5)->state(['role' => 'receptionist'])->create();

        // Create room types
        RoomType::updateOrCreate(
            ['name' => 'Standard Room'],
            [
                'description' => 'Comfortable room with essential amenities and modern décor',
                'capacity_adults' => 2,
                'capacity_children' => 0,
                'price_per_night' => 99.99,
                'image_url' => 'images/hotel/room-1.jpg',
                'is_active' => true,
            ],
        );

        RoomType::updateOrCreate(
            ['name' => 'Junior Suite'],
            [
                'description' => 'Spacious suite with separate sitting area and premium furnishings',
                'capacity_adults' => 2,
                'capacity_children' => 1,
                'price_per_night' => 149.99,
                'image_url' => 'images/hotel/room-2.jpg',
                'is_active' => true,
            ],
        );

        RoomType::updateOrCreate(
            ['name' => 'Executive Suite'],
            [
                'description' => 'Luxurious suite with executive amenities and concierge service',
                'capacity_adults' => 4,
                'capacity_children' => 2,
                'price_per_night' => 199.99,
                'image_url' => 'images/hotel/room-3.jpg',
                'is_active' => true,
            ],
        );

        RoomType::updateOrCreate(
            ['name' => 'Super Deluxe'],
            [
                'description' => 'Ultra-luxurious suite with premium services and exclusive amenities',
                'capacity_adults' => 6,
                'capacity_children' => 3,
                'price_per_night' => 299.99,
                'image_url' => 'images/hotel/room-1.jpg',
                'is_active' => true,
            ],
        );

        RoomType::updateOrCreate(
            ['name' => 'Family Room'],
            [
                'description' => 'Spacious family accommodation with multiple beds and amenities for children',
                'capacity_adults' => 4,
                'capacity_children' => 3,
                'price_per_night' => 249.99,
                'image_url' => 'images/hotel/room-2.jpg',
                'is_active' => true,
            ],
        );

        // Create rooms for each room type
        $roomTypes = RoomType::where('is_active', true)->get();
        foreach ($roomTypes as $roomType) {
            for ($i = 1; $i <= 3; $i++) {
                Room::updateOrCreate(
                    [
                        'room_type_id' => $roomType->id,
                        'room_number' => $roomType->id . '0' . $i,
                    ],
                    [
                        'floor' => $i,
                        'status' => 'available',
                        'notes' => 'Room for ' . $roomType->name,
                    ],
                );
            }
        }

        $this->call(HeroSlideSeeder::class);
        $this->call(AboutPageSeeder::class);
        $this->call(ServicePageSeeder::class);
        $this->call(FooterPageSeeder::class);
        $this->call(ContactPageSeeder::class);
        $this->call(BookingPageSeeder::class);

        // Create testimonials
        $guests = User::factory(6)->create();
        foreach ($guests as $guest) {
            Testimonial::create([
                'user_id' => $guest->id,
                'content' => $this->getRandomTestimonial(),
                'rating' => rand(4, 5),
                'is_approved' => true,
            ]);
        }

    }

    private function getRandomTestimonial(): string
    {
        $testimonials = [
            'The service was outstanding! Every detail was perfect. The rooms are beautifully designed and the staff is incredibly attentive.',
            'A wonderful experience from check-in to check-out. Highly recommend this hotel for anyone looking for luxury and comfort.',
            'The facilities are world-class and the location is perfect. Will definitely book again for our next vacation.',
            'Exceptional service and attention to detail. The best hotel experience we\'ve had in years.',
            'Amazing view, comfortable beds, and friendly staff. Everything we could ask for in a hotel.',
            'Five-star experience at every touchpoint. From the food to the amenities, everything was perfect.',
        ];

        return $testimonials[array_rand($testimonials)];
    }
}
