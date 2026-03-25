<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => \App\Models\Product::inRandomOrder()->first()->id,
            'sku' => strtoupper(fake()->bothify('SKU-####')),
            'price' => fake()->numberBetween(500, 5000),
            'tax' => fake()->numberBetween(5, 18),
            'discount' => fake()->numberBetween(0, 100),
            'image' => 'variant.jpg',
        ];
    }
}
