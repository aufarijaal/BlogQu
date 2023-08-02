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
    public function __invoke(Request $request, $tagSlug)
    {
        $currentPage = $request->query("page") ?? 1;
        $dataPerPage = 10;
        $nextPage = (int) $currentPage + 1;
        $prevPage = (int) $currentPage - 1;
        $hasNextPage = null;
        $hasPrevPage = null;
        $totalPages = null;
        $totalData = null;

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
            DB::raw("(SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) as likes_count"),
            DB::raw("(SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) as comments_count")
        )
            ->join("users", "users.id", "=", "posts.user_id")
            ->join("profiles", "profiles.user_id", "=", "users.id")
            ->join("categories", "categories.id", "=", "posts.category_id")
            ->join("post_tags", "post_tags.post_id", "=", "posts.id")
            ->join("tags", "tags.id", "=", "post_tags.tag_id")
            ->whereRaw("posts.status = ? AND tags.slug = ?", ["published", $tagSlug])
            ->limit($dataPerPage)
            ->offset($dataPerPage * ($currentPage - 1))
            ->get();

        $totalData = DB::table('posts')->select(DB::raw("COUNT(*) as total_count"))
            ->join("users", "users.id", "=", "posts.user_id")
            ->join("profiles", "profiles.user_id", "=", "users.id")
            ->join("categories", "categories.id", "=", "posts.category_id")
            ->join("post_tags", "post_tags.post_id", "=", "posts.id")
            ->join("tags", "tags.id", "=", "post_tags.tag_id")
            ->whereRaw("posts.status = ? AND tags.slug = ?", ["published", $tagSlug])
            ->get()->first()->total_count;

        $totalPages = (int) ceil($totalData / $dataPerPage);
        $hasPrevPage = $currentPage > 1;
        $hasNextPage = $currentPage < $totalPages;

        return view("posts.post-by-tag", [
            "posts" => $posts,
            "tag" => $tag,
            "nextPage" => $nextPage,
            "prevPage" => $prevPage,
            "hasPrevPage" => $hasPrevPage,
            "hasNextPage" => $hasNextPage,
            "currentPage" => $currentPage,
            "dataPerPage" => $dataPerPage,
            "totalData" => $totalData,
            "totalPages" => $totalPages
        ]);
    }
}
