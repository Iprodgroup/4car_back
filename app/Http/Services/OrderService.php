<?php

namespace App\Http\Services;

use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;

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
}