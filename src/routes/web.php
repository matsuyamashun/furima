<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\CustomRegisterController;

Route::middleware('auth')->group(function () 
{

    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/mylist',[ProductController::class,'mylist'])->name('mylist');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/logout', [AuthController::class,'logout'])->name('logout');
});

Route::post('/register', [CustomRegisterController::class, 'store'])->name('register.store');


