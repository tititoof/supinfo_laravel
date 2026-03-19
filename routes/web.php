<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartReceipController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('articles', ArticleController::class);
Route::resource('cart', CartController::class);
Route::resource('receips', ReceipController::class);
Route::resource('cart-receip', CartReceipController::class);