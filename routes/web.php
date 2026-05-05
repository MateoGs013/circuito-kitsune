<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
Route::get('/productos/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/transmisiones', [PostController::class, 'index'])->name('posts.index');
Route::get('/transmisiones/{post:slug}', [PostController::class, 'show'])->name('posts.show');
