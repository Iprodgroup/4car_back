<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/news', [NewsController::class, 'index'])->name('news');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
