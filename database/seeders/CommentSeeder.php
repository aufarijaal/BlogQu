<?php

namespace Database\Seeders;

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
        // Fetch all post, user, and comment ids to avoid N+1 queries
        $postIds = \App\Models\Post::pluck('id')->toArray();
        $userIds = \App\Models\User::pluck('id')->toArray();
        
        for ($i = 0; $i < 1000; $i++) {
            $post_id = array_rand($postIds);
            $user_id = array_rand($userIds);
            $t = now();

            DB::table("comments")->insertOrIgnore([
                "post_id" => $post_id,
                "user_id" => $user_id,
                "parent_id" => null,
                "content" => fake()->words(fake()->numberBetween(3, 20), true),
                "created_at" => $t,
                "updated_at" => $t
            ]);
        }
    }
}
