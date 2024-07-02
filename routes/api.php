<?php

use App\Http\Controllers\DiskController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PaymentCardController;
use App\Http\Controllers\TiresController;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(
    ['news' => NewsController::class,
     'tires' => TiresController::class,
     'disk' => DiskController::class,
     'payment-card' => PaymentCardController::class,
     

]);
