<?php

use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

Route::prefix("likes")->group(function () {
    Route::get("/", [LikeController::class, "show"])->name("likes.current_user");
    Route::get("{username}", [LikeController::class, "show"])->name("likes.by_username");


    Route::middleware('auth')->post("/", [LikeController::class, "store"])->name("likes.store");
    Route::middleware('auth')->delete("/", [LikeController::class, "destroy"])->name("likes.destroy");
});