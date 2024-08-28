<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManufacturersController;

//use hb\epay\HBepay;
//use Faker\Provider\ar_EG\Payment;
//Route::get('/pay', function()
//    {
//        $pay_order = new HBepay();
//        return $pay_order->gateway("test", "test", "yF587AV9Ms94qN2QShFzVR3vFnWkhjbAK3sG","67e34d63-102f-4bd1-898e-370781d0074d",
//        "300022002",10,"KZT","https://example.kz/success.html", "https://example.kz/failure.html","https://example.kz/",
//        "https://example.kz/order/1123/fail","RU","HBpaymentgateway", "test1", "", "");
//    }
//);
//Products
Route::get('/products', [ProductController::class, 'showAllProducts'])->name('admin.products.index');
//Categories
Route::get('/categories', [CategoryController::class, 'showAllCategories'])->name('admin.categories.index');
//Manufacturers
Route::get('/manufacturers', [ManufacturersController::class, 'showAllManufacturers'])->name('admin.manufacturers.index');
//Отзывы
Route::get('/reviews', [ReviewsController::class, 'showAllReviews'])->name('admin.reviews.index');
//Users
Route::get('/users', [UsersController::class, 'showAllUsers'])->name('admin.users.index');
//Dashboard
Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('admin.dashboard.index');
