<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class VariantAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'variant_id' => \App\Models\ProductVariant::inRandomOrder()->first()->id,
            'attribute_id' => \App\Models\Attribute::inRandomOrder()->first()->id,
            'attribute_value_id' => \App\Models\AttributeValue::inRandomOrder()->first()->id,
        ];
    }
}
