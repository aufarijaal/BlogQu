<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Posts\PostByCategoryController;

Route::prefix("categories")->group(function () {
    Route::get("{categorySlug}", PostByCategoryController::class)->name("post_by_category");
});