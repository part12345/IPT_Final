<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'T-Shirts', 'Jeans', 'Dresses', 'Jackets',
                'Activewear', 'Accessories', 'Hoodies',
            ]) . ' ' . fake()->unique()->numberBetween(1, 9999),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}