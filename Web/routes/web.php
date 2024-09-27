<?php

use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('/', function () {
    return view('index');
})->middleware(['auth', 'verified']);

Route::get('/', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/scan',[\App\Http\Controllers\MainController::class,'scan_index']);
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');

    Route::post('/api/chat/send', [ChatController::class, 'sendMessage']);



    // In web.php
    Route::post('/user/update-phone', [UserController::class, 'updatePhone'])->name('user.updatePhone');






// Routes for product management
    Route::get('/marketplace', [ProductController::class, 'index'])->name('marketplace.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('marketplace.create');
    Route::post('/products', [ProductController::class, 'store'])->name('marketplace.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('marketplace.show');
    // Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('marketplace.edit');
    // Route::put('/products/{product}', [ProductController::class, 'update'])->name('marketplace.update');
    // Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('marketplace.destroy');



//    Route::get('/chat/{userId}', [ChatController::class, 'start'])->name('chat.start');

});

require __DIR__.'/auth.php';
