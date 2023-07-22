<?php

use App\Http\Controllers\Authors\AuthorVisitController;
use Illuminate\Support\Facades\Route;

Route::prefix("authors")->group(function () {
    Route::get("{username}", AuthorVisitController::class)->name("authors.visit");
});