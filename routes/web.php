<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('welcome');
});

// Cart routes
Route::middleware(['auth'])->group(function () {
    Route::post('/add-to-cart', [CartController::class, 'store'])->name('add-to-cart');
    Route::post('/add-to-cart-detail', [CartController::class, 'addFromDetail'])->name('add-to-cart-detail');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
});
