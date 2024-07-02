<?php

use App\Http\Controllers\DiskController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PaymentCardController;
use App\Http\Controllers\TiresController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/payment-cards', [PaymentCardController::class, 'index']);
    Route::post('/payment-cards', [PaymentCardController::class, 'store']);
    Route::delete('/payment-cards/{paymentCard}', [PaymentCardController::class, 'destroy']);
    Route::post('orders', [OrderController::class, 'store']);
    Route::post('cart/addDisks', [CartController::class, 'addToCartDisks']);
    Route::post('cart/addTires', [CartController::class, 'addToCartTires']);
    Route::delete('cart/clear/{id}', [CartController::class, 'cleanOneElementFromCart']);
    Route::delete('cart/clear', [CartController::class, 'cleanCart']);
    Route::get('cart', [CartController::class, 'getCart']);
});

Route::apiResources(
    ['news' => NewsController::class,
     'tires' => TiresController::class,
     'disk' => DiskController::class,
     'payment-card' => PaymentCardController::class,   
]);

