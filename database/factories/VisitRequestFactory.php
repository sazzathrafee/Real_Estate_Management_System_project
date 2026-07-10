<?php

namespace Database\Factories;

use App\Models\VisitRequest;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VisitRequest>
 */
class VisitRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'buyer_id' => User::factory()->buyer()->create()->id,
            'visit_date' => fake()->dateTimeBetween('+1 day', '+30 days')->format('Y-m-d'),
            'visit_time' => fake()->time('H:i'),
            'message' => fake()->sentence(),
            'request_status' => fake()->randomElement(['pending', 'approved', 'rejected', 'completed']),
        ];
    }

    /**
     * Create a pending request
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'request_status' => 'pending',
        ]);
    }

    /**
     * Create an approved request
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'request_status' => 'approved',
        ]);
    }
}
