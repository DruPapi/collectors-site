<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CollectibleController;
use App\Http\Controllers\Api\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('home', [HomeController::class, 'index']);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('collectibles', [CollectibleController::class, 'index']);
Route::get('collectibles/{id}', [CollectibleController::class, 'show'])->where('id', '[0-9]+');
