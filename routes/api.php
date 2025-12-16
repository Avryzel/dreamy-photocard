<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FrontController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/groups', [FrontController::class, 'getGroups']);
Route::get('/photocards', [FrontController::class, 'getPhotocards']);

Route::post('/checkout', [FrontController::class, 'checkout']);