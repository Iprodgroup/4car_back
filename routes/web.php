<?php

use App\Http\Controllers\Admin\CommentsController;
use App\Http\Controllers\Admin\OrdersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManufacturersController;

////use hb\epay\HBepay;
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
Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('admin.categories.edit');
Route::put('/categories/update/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
//Manufacturers
Route::get('/manufacturers', [ManufacturersController::class, 'showAllManufacturers'])->name('admin.manufacturers.index');
Route::get('/manufacturers/edit/{id}', [ManufacturersController::class, 'edit'])->name('admin.manufacturers.edit');
Route::put('manufacturers/update/{id}', [ManufacturersController::class, 'update'])->name('admin.manufacturers.update');
Route::delete('manufacturers/{id}', [ManufacturersController::class, 'destroy'])->name('admin.manufacturers.destroy');
//Отзывы
Route::get('/reviews', [ReviewsController::class, 'showAllReviews'])->name('admin.reviews.index');
Route::delete('/reviews/{id}', [ReviewsController::class, 'destroy'])->name('admin.reviews.delete');
//Users
Route::get('/users', [UsersController::class, 'showAllUsers'])->name('admin.users.index');
//Dashboard
Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('admin.dashboard.index');
//Orders
Route::get('/orders', [OrdersController::class, 'getAllOrders'])->name('admin.orders.index');
Route::delete('orders/{id}', [OrdersController::class, 'destroy'])->name('admin.orders.delete');
//Comments
Route::get('/comments/', [CommentsController::class, 'index'])->name('admin.comments.index');
Route::delete('comments/{id}', [CommentsController::class, 'destroy'])->name('admin.comments.delete');
