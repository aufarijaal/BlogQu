<?php

use App\Http\Controllers\Authors\AuthorFavoritePostsController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

Route::prefix("favorites")->group(function () {
    Route::get("{username}", [FavoriteController::class, "show"])->name("favorites.by_username");

    Route::middleware("auth")->group(function() {
        Route::get("/", AuthorFavoritePostsController::class)->name("favorites.current_user");
        Route::post("/", [FavoriteController::class, "store"])->name("favorites.store");
        Route::delete("/", [FavoriteController::class, "destroy"])->name("favorites.destroy");
    });
});
