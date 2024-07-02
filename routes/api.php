<?php

use App\Http\Controllers\DiskController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PaymentCardController;
use App\Http\Controllers\TiresController;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\CartController;



Route::middleware('auth:sanctum')->group(function () {
    Route::post('cart/addDisks', [CartController::class, 'addToCartDisks']);
    Route::post('cart/addTires', [CartController::class, 'addToCartTires']);
    Route::get('cart', [CartController::class, 'getCart']);
});

Route::apiResources(
    ['news' => NewsController::class,
     'tires' => TiresController::class,
     'disk' => DiskController::class,
     'payment-card' => PaymentCardController::class,   
]);

