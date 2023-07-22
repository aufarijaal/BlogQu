<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __invoke()
    {
        $posts = DB::table('posts')->select(
            "posts.id as post_id",
            "posts.user_id as author_id",
            "users.name as author_name",
            "profiles.username as author_username",
            "profiles.pp as author_pp",
            "posts.category_id",
            "categories.name as category_name",
            "categories.slug as category_slug",
            "posts.title as post_title",
            "posts.slug as post_slug",
            "posts.thumbnail as post_thumbnail",
            "posts.status as post_status",
            "posts.parent_id as post_parent_id",
            "posts.updated_at",
        )->join("users", "users.id", "=", "posts.user_id")
            ->join("profiles", "profiles.user_id", "=", "users.id")
            ->join("categories", "categories.id", "=", "posts.category_id")
            ->where("posts.status", "published")
            ->groupBy(
                "posts.id",
            )
            ->limit(8)
            ->inRandomOrder()
            ->get();
        $categories = DB::table("categories")->inRandomOrder()->limit(10)->get();
        $tags = DB::table("tags")->inRandomOrder()->limit(15)->get();

        return view("home", [
            "posts" => $posts,
            "categories" => $categories,
            "tags" => $tags
        ]);
    }
}
