<?php

namespace Database\Factories;

use App\Models\PropertyCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyCategoryFactory extends Factory
{
    protected static array $categories = [
        ['name' => 'Apartment', 'desc' => 'Modern apartment units in residential buildings'],
        ['name' => 'Duplex', 'desc' => 'Two-floor residential units with separate entrances'],
        ['name' => 'Villa', 'desc' => 'Luxury standalone villas with premium amenities'],
        ['name' => 'Residential House', 'desc' => 'Independent houses for family living'],
        ['name' => 'Commercial Office', 'desc' => 'Office spaces for businesses and startups'],
        ['name' => 'Residential Plot', 'desc' => 'Vacant land plots for building homes'],
    ];

    public function definition(): array
    {
        $category = fake()->unique()->randomElement(static::$categories);
        return [
            'category_name' => $category['name'],
            'description' => $category['desc'],
        ];
    }
}
