<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'comment' => fake()->paragraph(),
            'assessment' => fake()->numberBetween(1,5),
            'user_id' => User::inRandomOrder()->first()->id,
            'product_id' => Product::inRandomOrder()->first()->id,
        ];
    }
}
