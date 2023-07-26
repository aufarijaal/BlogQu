<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepliesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $comments = Comment::whereNull('parent_id')->get();
        $users = User::all();

        foreach ($comments as $comment) {
            $repliesCount = mt_rand(0, 5);

            for ($i = 0; $i < $repliesCount; $i++) {
                Comment::create([
                    'post_id' => $comment->post_id,
                    'user_id' => $users->random()->id,
                    'content' => $faker->text(200),
                    'parent_id' => $comment->id,
                ]);
            }
        }
    }
}
