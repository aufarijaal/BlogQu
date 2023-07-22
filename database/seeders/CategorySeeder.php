<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            "Science and Technology",
            "Health and Wellness",
            "Business and Entrepreneurship",
            "Politics and Current Affairs",
            "Arts and Culture",
            "Sports and Fitness",
            "Travel and Adventure",
            "Food and Cooking",
            "Fashion and Style",
            "Education and Learning",
            "Environment and Sustainability",
            "Personal Finance and Investing",
            "Parenting and Family",
            "Relationships and Dating",
            "Self-Improvement and Productivity",
            "History and Archaeology",
            "Psychology and Mental Health",
            "Entertainment and Pop Culture",
            "Home and Interior Design",
            "DIY and Crafts",
        ];

        foreach ($categories as $category) {
            \App\Models\Category::factory()->create([
                "name" => $category,
                "slug" => \Illuminate\Support\Str::slug($category)
            ]);
        }
    }
}
