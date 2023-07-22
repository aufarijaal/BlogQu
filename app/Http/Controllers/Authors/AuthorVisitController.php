<?php

namespace App\Http\Controllers\Authors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorVisitController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($username)
    {
        $author = DB::table("users")->select(
            "users.id as author_id",
            "users.name as author_name",
            "profiles.username as author_username",
            "profiles.pp as author_pp",
            "profiles.bio as author_bio",
            "profiles.about as author_about",
            "users.created_at as joined_at"
        )->join("profiles", "profiles.user_id", "=", "users.id")
            ->where("profiles.username", $username)
            ->get()->first();

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
        )
            ->join("users", "users.id", "=", "posts.user_id")
            ->join("profiles", "profiles.user_id", "=", "users.id")
            ->join("categories", "categories.id", "=", "posts.category_id")
            ->where(function ($query) {
                $query->where("posts.status", "published")
                    ->orWhere("posts.status", "archived");
            })
            ->where("profiles.username", $username)
            ->get();

        return view("authors.visit", [
            "author" => $author,
            "posts" => $posts
        ]);
    }
}
