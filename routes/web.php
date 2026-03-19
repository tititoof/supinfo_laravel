<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('articles', ArticleController::class);
Route::resource('cart', CartController::class);