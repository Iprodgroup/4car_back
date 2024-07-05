<?php
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DiskController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PaymentCardController;
use App\Http\Controllers\TiresController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('cart', [CartController::class, 'getCart']);
    Route::post('orders', [OrderController::class, 'store']);
    Route::delete('cart/clear', [CartController::class, 'cleanCart']);
    
    Route::get('/payment-cards', [PaymentCardController::class, 'index']);
    Route::post('/payment-cards', [PaymentCardController::class, 'store']);
    Route::delete('/payment-cards/{paymentCard}', [PaymentCardController::class, 'destroy']);
    
    Route::post('cart/addDisks', [CartController::class, 'addToCartDisks']);
    Route::post('cart/addTires', [CartController::class, 'addToCartTires']);
    Route::delete('cart/clear/{id}', [CartController::class, 'cleanOneElementFromCart']);

    Route::post('/reviews/{reviewableType}/{reviewableId}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

Route::apiResources(
    [
        'news' => NewsController::class,
        'disk' => DiskController::class,
        'tires' => TiresController::class, 
    ]);

