<?php

use App\Http\Controllers\Admin\DiskController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\TiresController;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Support\Facades\Route;
use hb\epay\HBepay;

Route::get('/pay', function()
    {
        $pay_order = new HBepay();
        return $pay_order->gateway("test", "test", "yF587AV9Ms94qN2QShFzVR3vFnWkhjbAK3sG","67e34d63-102f-4bd1-898e-370781d0074d",
        "300022002",10,"KZT","https://example.kz/success.html", "https://example.kz/failure.html","https://example.kz/",
        "https://example.kz/order/1123/fail","RU","HBpaymentgateway", "test1", "", "");
    }
);
Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Route::get('/tires', [TiresController::class, 'index'])->name('admin.tires.index');
    Route::get('/disks',[DiskController::class, 'index'])->name('admin.disks.index');
    Route::get('/news', [AdminNewsController::class, 'index'])->name('admin.news.index');
    Route::get('/index', [IndexController::class, 'index'])->name('admin.index');  
});