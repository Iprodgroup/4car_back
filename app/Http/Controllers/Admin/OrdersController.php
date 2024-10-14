<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product\Order;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function getAllOrders()
    {
        $orders = Order::query()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('admin.orders.index');
    }
}
