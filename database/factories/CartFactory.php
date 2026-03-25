<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cart;
use App\Models\User;
use App\Models\ProductVariant;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition(): array
    {
        $user_id = User::inRandomOrder()->value('id');
        $variant_id = ProductVariant::inRandomOrder()->value('id');

        return [
            'user_id' => $user_id,
            'variant_id' => $variant_id,
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->numberBetween(100, 5000),
        ];
    }
}
