<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostReadController extends Controller
{
    public function __invoke($authorUsername, $postSlug)
    {
        $post = DB::table('posts')->select(
            "posts.id as post_id",
            "posts.user_id as author_id",
            "users.name as author_name",
            "profiles.username as author_username",
            "profiles.pp as author_pp",
            "profiles.bio as author_bio",
            "posts.category_id",
            "categories.name as category_name",
            "categories.slug as category_slug",
            "posts.title as post_title",
            "posts.slug as post_slug",
            "posts.body as post_body",
            "posts.thumbnail as post_thumbnail",
            "posts.status as post_status",
            "posts.parent_id as post_parent_id",
            "posts.updated_at",
            DB::raw("GROUP_CONCAT(tags.id) as tag_ids"),
            DB::raw("GROUP_CONCAT(tags.name) as tag_names"),
            DB::raw("GROUP_CONCAT(tags.slug) as tag_slugs"),
        )
            ->join("users", "users.id", "=", "posts.user_id")
            ->join("profiles", "profiles.user_id", "=", "users.id")
            ->join("categories", "categories.id", "=", "posts.category_id")
            ->leftJoin("post_tags", "post_tags.post_id", "=", "posts.id")
            ->leftJoin("tags", "tags.id", "=", "post_tags.tag_id")
            ->where("posts.slug", $postSlug)
            ->where("profiles.username", $authorUsername)
            ->groupBy("posts.id")
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
            ->where("posts.status", "published")
            ->where("profiles.username", $authorUsername)
            ->groupBy("posts.id")
            ->limit(9)
            ->inRandomOrder()
            ->get();

        $comments = \App\Models\Comment::with([
                "replies.commenter:id,name" => ["profile:user_id,username,pp"],
                "commenter:id,name" => ["profile:user_id,username,pp"],
                "likes.user:id"
            ])
            ->where("post_id", 132)
            ->where("parent_id", null)
            ->get()->toArray();

        $tags = null;
        $like = null;
        $favorite = null;

        if (auth()->user()) {
            $like = \App\Models\Like::where("post_id", $post->post_id)->where("user_id", auth()->user()->id)->get()->first();
            $favorite = \App\Models\Favorite::where("post_id", $post->post_id)->where("user_id", auth()->user()->id)->get()->first();
        }

        $likeCount = \App\Models\Like::where("post_id", $post->post_id)->get()->count();
        $favoriteCount = \App\Models\Favorite::where("post_id", $post->post_id)->get()->count();
        $commentsCount = \App\Models\Comment::where("post_id", $post->post_id)->where("parent_id", null)->get()->count();

        if (!is_null($post->tag_ids)) {
            $tags = collect();
            $tag_ids = explode(",", $post->tag_ids);
            $tag_names = explode(",", $post->tag_names);
            $tag_slugs = explode(",", $post->tag_slugs);

            foreach ($tag_ids as $key => $tag_id) {
                $tags->push(
                    new \App\Models\Tag([
                        "id" => $tag_id,
                        "name" => $tag_names[$key],
                        "slug" => $tag_slugs[$key]
                    ])
                );
            }

            unset($post->tag_ids);
            unset($post->tag_names);
            unset($post->tag_slugs);
        }

        return view("posts.read", [
            "post" => $post,
            "posts" => $posts,
            "tags" => $tags,
            "like" => $like,
            "comments" => $comments,
            "favorite" => $favorite,
            "likeCount" => $likeCount,
            "favoriteCount" => $favoriteCount,
            "commentsCount" => $commentsCount
        ]);
    }
}
