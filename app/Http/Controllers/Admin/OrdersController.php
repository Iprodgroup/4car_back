<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function getAllOrders()
    {
        $orders = Order::query()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required',
            'number' => 'required',
            'city' => 'required',
            'district' => 'nullable',
            'delivery_method' => 'required',
            'town' => 'nullable',
            'adres' => 'nullable',
            'orient' => 'nullable',
            'work_adres' => 'nullable',
            'phone' => 'nullable',
            'comment' => 'nullable',
            'coupon' => 'nullable',
            'payment_method' => 'required',
            'sum' => 'required',
            'products' => 'required',
            'status_id' => 'required',
        ]);

        $order->update($validatedData);

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');

    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('admin.orders.index');
    }
}
