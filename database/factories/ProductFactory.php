<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => fake()->unique()->words(3, true),
            'sku' => strtoupper(fake()->unique()->bothify('SH-####??')),
            'description' => fake()->sentence(12),
            'size' => fake()->randomElement(['S', 'M', 'L', 'XL']),
            'color' => fake()->safeColorName(),
            'price' => fake()->randomFloat(2, 150, 2500),
            'stock_quantity' => fake()->numberBetween(0, 100),
            'image_url' => null,
            'is_active' => true,
        ];
    }
}