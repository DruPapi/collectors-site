<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CollectibleController;
use App\Http\Controllers\Api\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('home', [HomeController::class, 'index']);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('collectibles', [CollectibleController::class, 'index']);
Route::get('collectibles/{id}', [CollectibleController::class, 'show'])->where('id', '[0-9]+');
Route::get('cart', [CartController::class, 'index']);
Route::post('cart/add', [CartController::class, 'add']);
Route::delete('cart/remove', [CartController::class, 'remove']);

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
