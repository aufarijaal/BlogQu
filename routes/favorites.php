<?php

use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

Route::prefix("favorites")->group(function () {
    Route::middleware('auth')->get("/", function() {
        $posts = \Illuminate\Support\Facades\DB::table('posts')->select(
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
            ->whereIn("posts.id", \Illuminate\Support\Facades\DB::table("favorites")->select("post_id")->where("user_id", auth()->user()->id))
            ->groupBy(
                "posts.id",
            )->get();

        return view("posts.auth-user-favorites", [
            "posts" => $posts
        ]);
    })->name("favorites.current_user");
    Route::get("{username}", [FavoriteController::class, "show"])->name("favorites.by_username");
    Route::post("/", [FavoriteController::class, "store"])->name("favorites.store");
    Route::delete("/", [FavoriteController::class, "destroy"])->name("favorites.destroy");
});