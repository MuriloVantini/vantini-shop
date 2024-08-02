<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'description' => fake()->paragraph(2, true),
            'images' => ['https://acdn.mitiendanube.com/stores/118/472/products/anos-70-costas-3b58e1559a97e8808616351945345653-240-0.jpg'],
            'rating' => fake()->unique()->randomFloat(2, 1, 5),
            'price' => fake()->unique()->randomFloat(2, 50, 2000),
        ];
    }
}
