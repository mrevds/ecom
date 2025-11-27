<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\OrderController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::post('/add-card', [CardController::class, 'addCard']);
    Route::get('/cards', [CardController::class, 'getUserCards']);
    Route::post('/add-item-to-basket',[BasketController::class, 'addItem']);
    Route::get('/get-basket-list',[BasketController::class, 'getBasketList']);
    Route::delete('/delete-item-from-basket/{id}', [BasketController::class, 'removeFromList']);
    Route::post('/make-order', [OrderController::class, 'makeOrder']);
    Route::post('/pay-order', [CardController::class, 'pay']);
    Route::post('/set-address', [OrderController::class,'setAddress']);
});


Route::post('/register-customer', [UserController::class, 'registerCustomer']);
Route::post('/register-seller', [UserController::class, 'registerSeller']);
Route::post('/login', [UserController::class,'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
