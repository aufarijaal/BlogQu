<?php

use App\Http\Controllers\Search\SearchAuthorController;
use App\Http\Controllers\Search\SearchCategoryController;
use App\Http\Controllers\Search\SearchPostController;
use App\Http\Controllers\Search\SearchTagController;
use Illuminate\Support\Facades\Route;

Route::prefix("search")->group(function () {
    Route::get("/", function() {
        return redirect()->route("search.posts", ["q" => ""]);
    })->name("search");

    // Searching about posts
    Route::get("posts", SearchPostController::class)->name("search.posts");

    // Searching about tags
    Route::get("tags", SearchTagController::class)->name("search.tags");;

    // Searching about categories
    Route::get("categories", SearchCategoryController::class)->name("search.categories");

    // Searching about authors
    Route::get("authors", SearchAuthorController::class)->name("search.authors");
});
