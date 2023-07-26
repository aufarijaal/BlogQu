<?php

use App\Http\Controllers\AdditionalProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilePictureController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', HomeController::class)->name("home");

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::patch('/additional-profile', [AdditionalProfileController::class, 'store'])->name('additional_profile.update');

    Route::patch('/additional-profile/pp', [ProfilePictureController::class, 'store'])->name('additional_profile.pp.store');
    Route::delete('/additional-profile/pp', [ProfilePictureController::class, 'destroy'])->name('additional_profile.pp.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/posts.php';
require __DIR__.'/tags.php';
require __DIR__.'/categories.php';
require __DIR__.'/authors.php';
require __DIR__.'/search.php';
require __DIR__.'/likes.php';
require __DIR__.'/favorites.php';
require __DIR__.'/comments.php';
