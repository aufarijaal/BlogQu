<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {
            $userIds = $users->random(mt_rand(0, $users->count()))->pluck('id');

            foreach ($userIds as $userId) {
                Favorite::firstOrCreate([
                    'post_id' => $post->id,
                    'user_id' => $userId,
                ]);
            }
        }
    }
}
