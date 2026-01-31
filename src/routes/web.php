<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\CustomRegisterController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AddressController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;


Route::middleware('auth','verified')->group(function ()
{
    Route::get('/mylist', [FavoriteController::class, 'index'])->name('favorite.index');

    Route::get('/profile/setup', [ProfileController::class, 'setup'])->name('profile.setup');
    Route::post('/profile/setup', [ProfileController::class, 'setupStore'])->name('profile.setup.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/logout', [AuthController::class,'logout'])->name('logout');

    Route::get('/mypage',[MypageController::class,'index'])->name('mypage');

    Route::post('/products/{product}/favorite', [FavoriteController::class, 'store'])->name('favorite.store');
    Route::delete('/products/{product}/favorite', [FavoriteController::class, 'destroy'])->name('favorite.destroy');

    Route::post('/comment/{id}', [CommentController::class, 'store'])->name('comment.store');

    Route::get('/sell',[ProductController::class,'sell'])->name('sell');
    Route::post('/sell',[ProductController::class,'store'])->name('sell.store');

    Route::get('/purchase/{id}',[PurchaseController::class,'show'])->name('purchase');
    Route::post('/purchase/{id}',[PurchaseController::class,'store'])->name('purchase.store');
    Route::get('/purchase/success/{id}', [PurchaseController::class, 'success'])->name('purchase.success');

    Route::get('/address/{product_id}',[AddressController::class,'show'])->name('address.show');
    Route::patch('/address/{product_id}',[AddressController::class,'update'])->name('address.update');

    Route::get('/chat/{transaction}',[ChatController::class,'show'])->name('chat');
    Route::post('/chat/{transaction}',[ChatController::class,'store'])->name('chat');
    Route::put('/chat/{message}', [ChatController::class, 'update'])->name('chat.update');
    Route::delete('/chat/{message}', [ChatController::class, 'destroy'])->name('chat.destroy');

    Route::post('/transaction/{transaction}/complete', [ChatController::class, 'complete'])->name('transaction.complete');

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews');
});

Route::get('/', [ProductController::class, 'index'])->name('index');

Route::get('/item/{id}',[ProductController::class,'show'])->name('item');

Route::post('/register', [CustomRegisterController::class, 'store'])->name('register.store');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/profile');
})->middleware(['auth', 'signed'])->name('verification.verify');



