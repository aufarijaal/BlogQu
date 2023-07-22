<?php

use App\Http\Controllers\Posts\MyPostsController;
use App\Http\Controllers\Posts\PostReadController;
use App\Http\Controllers\Posts\PostController;
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
        Route::post("new", [PostController::class, "create"])->name("posts.create");
        // Edit post
        Route::get("{postId}/edit", [PostController::class, "edit"])->name("posts.edit");
        // Save post
        Route::put("store", [PostController::class, "store"])->name("posts.store");

        // Save post thumbnail
        Route::put("store/thumbnail", [PostController::class, "uploadThumbnail"])->name("posts.store.thumbnail");

        Route::delete("store/thumbnail", [PostController::class, "deleteThumbnail"])->name("posts.store.thumbnail.delete");

        // Delete post
        Route::delete("{postId}/destroy", [PostController::class, "destroy"])->name("posts.destroy");
    });
});