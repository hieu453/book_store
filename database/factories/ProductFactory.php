<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
        $name = ucfirst(fake()->word());
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'width' => fake()->randomNumber(2, false),
            'height' => fake()->randomNumber(2, false),
            'language' => ucfirst(fake()->word()),
            'weight' => fake()->randomFloat(1, 20, 30),
            'author' => ucfirst(fake()->word()),
            'publisher' => ucfirst(fake()->word()),
            'published_date' => fake()->date(),
            'category_id' => fake()->numberBetween(1, 10),
            'quantity' => fake()->randomNumber(3, false),
            'price' => fake()->randomFloat(1, 1, 30),
        ];
    }
}
