<?php

namespace Database\Factories;

use Closure;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->words(fake()->numberBetween(1, 2), true);

        return [
            "name" => \Illuminate\Support\Str::title($name),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function(\App\Models\Category $category) {
            \App\Models\Category::find($category->id)->update([
                "slug" => \Illuminate\Support\Str::slug($category->id . "-" . $category->name)
            ]);
        });
    }
}
