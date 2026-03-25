<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderDetail>
 */
class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => \App\Models\Order::inRandomOrder()->first()->id,
            'variant_id' => \App\Models\ProductVariant::inRandomOrder()->first()->id,
            'order_quantity' => fake()->numberBetween(1, 5),
            'price_per_unit' => fake()->numberBetween(100, 5000),
            'discount' => fake()->numberBetween(0, 100),
            'tax' => fake()->numberBetween(5, 18),
        ];
    }
}
