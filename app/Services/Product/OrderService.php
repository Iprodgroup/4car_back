<?php

namespace App\Services\Product;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;

class OrderService
{
    public function getProductsFromCartToOrder(OrderRequest $request, Request $urequest)
    {
        $user = $urequest->user();

        $order = $user->orders()->create($request->validated());

        $cart = $urequest->session()->get('cart', []);

        if (!empty($cart)) {
            foreach ($cart['tires'] ?? [] as $tiresItem) {
                $order->tires()->attach($tiresItem['tires_id'], ['quantity' => $tiresItem['quantity']]);
            }
            foreach ($cart['disks'] ?? [] as $disksItem) {
                $order->disks()->attach($disksItem['disk_id'], ['quantity' => $disksItem['quantity']]);
            }
            $request->session()->forget('cart');
        }
        $paymentMethod = $order['payment_method'];

        if ($paymentMethod === 'transfer') {
            return redirect()->route('payment.page', ['order' => $order->id]);
        }

        return $order->toArray();
    }

    // TODO сделать функционал заказа
    public function orderProduct()
    {
        $order = auth()->user()->orders()->first();
        return $order;
    }
}
