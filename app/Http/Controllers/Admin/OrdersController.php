<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function getAllOrders()
    {
        $orders = Order::query()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }
}