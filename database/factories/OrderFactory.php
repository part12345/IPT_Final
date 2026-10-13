<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'order_number' => 'SH-' . fake()->unique()->numerify('##########'),
            'order_date' => fake()->dateTimeBetween('-60 days', 'now')->format('Y-m-d'),
            'status' => fake()->randomElement([
                'Pending', 'Processing', 'Shipped', 'Delivered',
            ]),
            'total_amount' => 0,
            'shipping_address' => fake()->address(),
            'notes' => null,
        ];
    }
}