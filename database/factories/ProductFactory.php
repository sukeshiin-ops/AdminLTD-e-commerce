<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = \App\Models\Product::class;

    public function definition(): array
    {
        // Category decide kar ke realistic product name generate karte hain
        $category = Category::inRandomOrder()->first();

        $productsByCategory = [
            'Mobiles' => ['iPhone 14', 'Samsung Galaxy S23', 'OnePlus 11', 'Google Pixel 8'],
            'Laptops' => ['MacBook Pro 16"', 'Dell XPS 15', 'HP Spectre x360', 'Lenovo ThinkPad X1'],
            'Cameras' => ['Canon EOS R5', 'Nikon D850', 'Sony A7 IV', 'Fujifilm X-T4'],
            'Headphones' => ['Bose QuietComfort 45', 'Sony WH-1000XM5', 'Beats Studio3', 'Sennheiser HD 560S'],
            'Smart Watches' => ['Apple Watch Series 9', 'Samsung Galaxy Watch 6', 'Fitbit Versa 4'],

            'Men Shirts' => ['Formal Cotton Shirt', 'Casual Denim Shirt', 'Checked Shirt', 'Linen Shirt'],
            'Women Dresses' => ['Evening Gown', 'Summer Dress', 'Cocktail Dress', 'Maxi Dress'],
            'Jeans' => ['Slim Fit Jeans', 'Regular Fit Jeans', 'High-Waist Jeans'],
            'Jackets' => ['Leather Jacket', 'Bomber Jacket', 'Denim Jacket', 'Windbreaker'],
            'Shoes' => ['Running Shoes', 'Formal Shoes', 'Casual Sneakers', 'Boots'],
        ];

        $categoryName = $category->title;

        // Agar us category ke liye products define nahi hain, random words
        $productName = $productsByCategory[$categoryName] ?? [$this->faker->words(2, true)];
        $productName = $this->faker->randomElement($productName);

        return [
            'product_name' => fake()->words(3, true),
            'small_description' => fake()->sentence(),
            'category_id' => $category->id,
            'product_price' => fake()->numberBetween(500, 5000),
            'product_image' => 'product.jpg',
            'description' => fake()->paragraph(),
            'discount' => fake()->numberBetween(0, 100),
            'tax' => fake()->numberBetween(5, 18),
        ];
    }
}
