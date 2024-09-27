<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\ProductController;



Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('index');
    });



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/user/update-phone', [UserController::class, 'updatePhone'])->name('user.updatePhone');


    Route::get('/marketplace', [ProductController::class, 'index'])->name('marketplace.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('marketplace.create');
    Route::post('/products', [ProductController::class, 'store'])->name('marketplace.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('marketplace.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('marketplace.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('marketplace.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('marketplace.destroy');

});

require __DIR__.'/auth.php';
