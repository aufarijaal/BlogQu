<?php

use App\Rules\AlphaNumSpaceComma;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix("tags")->group(function () {
    // Searching for a tag
    Route::get("/", function (Request $request) {
        $tags = \App\Models\Tag::query()
            ->where("name", "LIKE", sprintf("%%%s%%", $request->query("q")))
            ->get();

        return response($tags);
    });

    // Show posts based on certain tags
    Route::get("{tagSlug}", function (Request $request, $tagSlug) {
        $posts = \App\Models\Post::select([
            "id",
            "user_id",
            "category_id",
            "title",
            "slug",
            "thumbnail",
            "excerpt",
            "status",
            "parent_id",
            "updated_at"
        ])
            ->with("tags")
            ->whereHas("tags", function ($query) use ($tagSlug) {
                $query->where("slug", $tagSlug);
            })->get();

        return response($posts);
    });
});

Route::get("/", function (Request $request) {
    $posts = \App\Models\Post::inRandomOrder()->forPostCard()->where("status", "published")->take(6)->get();
    $categories = \App\Models\Category::inRandomOrder()->take(10)->get();
    $tags = \App\Models\Tag::inRandomOrder()->take(15)->get();

    return response([
        "posts" => $posts,
        "categories" => $categories,
        "tags" => $tags,
    ]);
});

Route::get("/categories/{categorySlug}", function ($categorySlug) {
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
        DB::raw("GROUP_CONCAT(tags.id) AS tag_ids"),
        DB::raw("GROUP_CONCAT(tags.name) AS tag_names"),
        DB::raw("GROUP_CONCAT(tags.slug) AS tag_slug")
    )->join("users", "users.id", "=", "posts.user_id")
        ->join("profiles", "profiles.user_id", "=", "users.id")
        ->join("categories", "categories.id", "=", "posts.category_id")
        ->join("post_tags", "post_tags.post_id", "=", "posts.id")
        ->join("tags", "tags.id", "=", "post_tags.tag_id")
        ->whereRaw("categories.slug = ?", [$categorySlug])
        ->groupBy(
            "posts.id",
        )
        ->limit(2)
        ->offset(0)
        ->inRandomOrder()->get();

    if (count($posts) === 0) return response("Not Found", 404);
    return response($posts);
});

Route::prefix("search")->group(function () {
    Route::get("posts", function (Request $request) {
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
            "posts.updated_at"
        )->join("users", "users.id", "=", "posts.user_id")
            ->join("profiles", "profiles.user_id", "=", "users.id")
            ->join("categories", "categories.id", "=", "posts.category_id")
            ->where("posts.status", "published")
            ->where(function ($query) use($request) {
                return $query->where("posts.title", "LIKE", sprintf("%%%s%%", $request->query("q")))
                ->orWhere("posts.excerpt", "LIKE", sprintf("%%%s%%", $request->query("q")))
                ->orWhere("posts.body", "LIKE", sprintf("%%%s%%", $request->query("q")));
            })
            ->groupBy(
                "posts.id",
            )
            ->limit(2)
            ->offset(0)
            ->toSql();

        return response($posts);
    });
});

Route::get('/posts/{username}', function($username) {
    $posts = \App\Models\User::with([
        "profile" => function($query) use($username) {
            $query->where("username", $username);
        }
    ])->get();

    return response($posts);
});

Route::get('/favorites', function() {
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
        "posts.updated_at"
    )->join("users", "users.id", "=", "posts.user_id")
        ->join("profiles", "profiles.user_id", "=", "users.id")
        ->join("categories", "categories.id", "=", "posts.category_id")
        ->whereIn("posts.id", DB::table("favorites")->select("post_id")->where("user_id", 4))
        ->groupBy(
            "posts.id",
        )->get();

    return response($posts);
});
