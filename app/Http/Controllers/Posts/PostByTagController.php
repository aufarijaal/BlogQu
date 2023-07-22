<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostByTagController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($tagSlug)
    {
        // TODO: Adjust this query to select posts by tag
        $tag = \App\Models\Tag::where("slug", $tagSlug)->get()->first();
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
            ->join("post_tags", "post_tags.post_id", "=", "posts.id")
            ->join("tags", "tags.id", "=", "post_tags.tag_id")
            ->whereRaw("posts.status = ? AND tags.slug = ?", ["published", $tagSlug])
            ->get();

        return view("posts.post-by-tag", [
            "posts" => $posts,
            "tagName" => $tag->name
        ]);
    }
}
