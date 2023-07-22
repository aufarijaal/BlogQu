<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'username' => fake()->userName(),
            'gender' => fake()->boolean() ? "M" : "F",
            'dob' => fake()->date(max: '-15 years'),
            'bio' => fake()->paragraph(1),
            'about' => fake()->realTextBetween(),
            'pp' => fake()->imageUrl(),
        ];
    }
}
