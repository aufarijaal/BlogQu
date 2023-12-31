<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {
            $commentsCount = mt_rand(0, 10);

            for ($i = 0; $i < $commentsCount; $i++) {
                Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                    'content' => $faker->text(200),
                ]);
            }
        }
    }
}
