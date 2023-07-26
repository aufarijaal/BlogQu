<?php

use App\Http\Controllers\Posts\MyPostsController;
use App\Http\Controllers\Posts\PostReadController;
use App\Http\Controllers\Posts\PostController;
use App\Http\Controllers\Posts\PostThumbnailController;
use Illuminate\Support\Facades\Route;

Route::prefix("posts")->group(function () {
    // Read specific post
    // Route::get("{authorName}/{postSlug}/read", PostReadController::class)->name("posts.read");
    Route::get("{authorUsername}/{postSlug}/read", PostReadController::class)->name("posts.read");

    // CRUD posts
    Route::middleware("auth")->group(function () {
        // Get all authenticated user posts
        Route::get("my-posts", MyPostsController::class)->name("posts.my");
        // Create new empty post
        Route::post("new", [PostController::class, "store"])->name("posts.create");
        // Edit post
        Route::get("{postId}/edit", [PostController::class, "edit"])->name("posts.edit");
        // Save post
        Route::put("store", [PostController::class, "update"])->name("posts.store");
        // Route::put("store", function() {
        //     dd(request()->all());
        // })->name("posts.store");

        // Save post thumbnail
        Route::put("store/thumbnail", [PostThumbnailController::class, "store"])->name("posts.thumbnail.store");

        Route::delete("store/thumbnail", [PostThumbnailController::class, "destroy"])->name("posts.thumbnail.destroy");

        // Delete post
        Route::delete("/", [PostController::class, "destroy"])->name("posts.destroy");
    });
});
