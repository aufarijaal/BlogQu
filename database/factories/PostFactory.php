<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = fake()->words(fake()->numberBetween(4, 8), true);
        $body = fake()->realTextBetween(500, 3000);

        return [
            "user_id" => \App\Models\User::all(["id"])->random()->id,
            "category_id" => \App\Models\Category::all(["id"])->random()->id,
            "title" => \Illuminate\Support\Str::title($title),
            "slug" => \Illuminate\Support\Str::slug($title . "-" . fake()->uuid()),
            "thumbnail" => fake()->boolean() ? fake()->imageUrl() : null,
            "body" => $body,
            "excerpt" => \Illuminate\Support\Str::limit($body, 100, ""),
            "status" => fake()->randomElement(["published", "archived", "draft"]),
            "created_at" => fake()->dateTimeBetween('-10 years'),
            "updated_at" => fake()->dateTimeBetween('-10 years')
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            if(!fake()->boolean(80)) return;
            $post->tags()->sync(\App\Models\Tag::all(["id"])->random(fake()->numberBetween(1, 5))->pluck("id")->toArray());
        });
    }
}
