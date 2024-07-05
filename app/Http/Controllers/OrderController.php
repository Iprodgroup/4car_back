<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'number' => 'required',
            'district ' => 'required',
            'city' => 'required',
            'delivery_method' => 'required|in:delivery,pickup',
            'town' => 'required',
            'adres' => 'required',
            'orient' => 'required',
            'work_adres' => 'required',
            'comment' => 'nullable',
            'coupon' => 'nullable',
            'payment_method' => 'required|in:cash,transfer',
        ]);

        $user = $request->user();

        $order = Order::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'district' => $request->district,
            'city' => $request->city,
            'delivery_method' => $request->delivery_method,
            'town' => $request->town,
            'adres' => $request->adres,
            'orient' => $request->orient,
            'work_adres' => $request->work_adres,
            'comment' => $request->comment,
            'coupon' => $request->coupon,
            'payment_method' => $request->payment_method,
        ]);

        $cartItems = Cart::where('user_id', $user->id)->get();
        foreach ($cartItems as $cartItem) {
            $order->tires()->attach($cartItem->tires_id, ['quantity' => $cartItem->quantity]);
            $order->disks()->attach($cartItem->disks_id, ['quantity' => $cartItem->quantity]);
            $cartItem->delete();
        }

        return $this->success('Заказ оформлен', 200);
    }
}
