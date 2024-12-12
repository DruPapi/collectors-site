<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('home', [HomeController::class, 'index']);
Route::get('categories', [CategoryController::class, 'index']);
