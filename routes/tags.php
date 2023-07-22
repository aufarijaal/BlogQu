<?php

use App\Http\Controllers\Posts\PostByTagController;
use Illuminate\Support\Facades\Route;

Route::prefix("tags")->group(function () {
    Route::get("{tagSlug}", PostByTagController::class)->name("post_by_tags.index");
});