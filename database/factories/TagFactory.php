<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->words(fake()->numberBetween(1, 4), true);

        return [
            "name" => \Illuminate\Support\Str::title($name),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function(\App\Models\Tag $tag) {
            \App\Models\Tag::find($tag->id)->update([
                "slug" => \Illuminate\Support\Str::slug($tag->id . "-" . $tag->name)
            ]);
        });
    }
}
