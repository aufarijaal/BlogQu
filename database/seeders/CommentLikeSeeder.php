<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comments = Comment::whereNull('parent_id')->get();
        $users = User::all();

        foreach ($comments as $comment) {
            $userIds = $users->random(mt_rand(0, $users->count()))->pluck('id');

            foreach ($userIds as $userId) {
                CommentLike::firstOrCreate([
                    'comment_id' => $comment->id,
                    'user_id' => $userId,
                ]);
            }
        }
    }
}
