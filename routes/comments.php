<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikeController;
use Illuminate\Support\Facades\Route;

Route::prefix("comments")->group(function () {
    Route::middleware("auth")->post("/", [CommentController::class, "store"])->name("comments.create");
    Route::middleware("auth")->put("/", [CommentController::class, "update"])->name("comments.update");
    Route::middleware("auth")->delete("/", [CommentController::class, "destroy"])->name("comments.destroy");
});

Route::prefix("comment-likes")->group(function () {
    Route::middleware("auth")->post("/", [CommentLikeController::class, "store"])->name("comment-likes.create");
    Route::middleware("auth")->delete("/", [CommentLikeController::class, "destroy"])->name("comment-likes.destroy");
});
