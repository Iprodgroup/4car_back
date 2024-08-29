<?php

namespace App\Services\Product;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;

class OrderService
{
    public function getOrders(): JsonResponse
    {
        $user = auth()->user();
        $orders = $user->orders()->paginate(10);

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'У вас пока нет заказов'], 200);
        }

        return $this->response(OrderResource::collection($orders));
    }

    public function getProductsFromCartToOrder(OrderRequest $request, Request $urequest)
    {
        $user = auth()->user();

        if (!$user) {
            throw new \Exception("User not authenticated");
        }

        $order = $user->orders()->create($request->validated());

        $cart = $urequest->session()->get('cart', []);

        if (!empty($cart)) {
            foreach ($cart['products'] ?? [] as $productItem) {
                $order->products()->attach($productItem['product_id'], ['quantity' => $productItem['quantity']]);
            }
            $urequest->session()->forget('cart');
        }

        $paymentMethod = $order->payment_method;
        if ($paymentMethod === 'transfer') {
            return redirect()->route('payment.page', ['order' => $order->id]);
        }
        return $order->toArray();
    }

    public function orderProduct(Request $request)
    {
        $order = auth()->user()->orders()->first();
        return $order;
    }
}
