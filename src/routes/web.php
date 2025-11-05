<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\CustomRegisterController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController; // ← 追加！

Route::middleware('auth')->group(function () 
{
    Route::get('/mylist', [FavoriteController::class, 'index'])->name('favorite.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/logout', [AuthController::class,'logout'])->name('logout');

    Route::get('/mypage',[MypageController::class,'index'])->name('mypage');
    Route::get('/purchased',[MypageController::class,'purchased'])->name('purchased');

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorite.index');
    Route::post('/favorite/{product}',[FavoriteController::class,'store'])->name('favorite.store');
    Route::delete('/favorite/{product}',[FavoriteController::class,'destroy'])->name('favorite.destroy');

    Route::post('/item/{id}/comment', [CommentController::class, 'store'])->name('comment.store');

    Route::get('/sell',[ProductController::class,'sell'])->name('sell');
    Route::post('/sell',[ProductController::class,'store'])->name('sell.store');
});

Route::get('/', [ProductController::class, 'index'])->name('index');

Route::get('/item/{id}',[ProductController::class,'show'])->name('item');

Route::post('/register', [CustomRegisterController::class, 'store'])->name('register.store');


