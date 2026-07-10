<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use App\Models\PropertyCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'seller_id' => User::factory()->seller()->create()->id,
            'category_id' => PropertyCategory::inRandomOrder()->first()?->id ?? PropertyCategory::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(4),
            'price' => fake()->numberBetween(50000, 1000000),
            'area_size' => fake()->numberBetween(500, 5000),
            'bedrooms' => fake()->numberBetween(1, 5),
            'bathrooms' => fake()->numberBetween(1, 3),
            'garage' => fake()->numberBetween(0, 2),
            'property_type' => fake()->randomElement(['sale', 'rent']),
            'city' => fake()->randomElement(['Dhaka', 'Khulna', 'Chattogram']),
            'division' => fake()->randomElement(['Dhaka', 'Khulna', 'Chattogram']),
            'location' => fake()->address(),
            'latitude' => fake()->latitude(22.5, 24.5),
            'longitude' => fake()->longitude(89.5, 91.5),
            'status' => 'available',
            'image' => null,
            'approval_status' => 'approved',
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'approval_status' => 'approved',
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'approval_status' => 'pending',
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'approval_status' => 'rejected',
        ]);
    }
}
