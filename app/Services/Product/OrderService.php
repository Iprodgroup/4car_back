<?php

namespace App\Services\Product;

use App\Traits\SlugTrait;
use Illuminate\Http\Request;
use App\Models\Product\Order;
use App\Models\Product\Product;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\OrderResource;

class OrderService
{
    use SlugTrait;
    public function getOrders(): JsonResponse
    {
        $user = auth()->user();
        $orders = $user->orders()->with('status')->paginate(10);

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'У вас пока нет заказов'], 200);
        }
        return response()->json(OrderResource::collection($orders));
    }

    public function createOrderWithoutCart(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'name' => 'required|string',
            'number' => 'required|string',
            'city' => 'nullable|string',
            'district' => 'nullable|string',
            'delivery_method' => 'required|in:delivery,pickup',
            'town' => 'nullable|string',
            'address' => 'nullable|string',
            'orient' => 'nullable|string',
            'work_address' => 'nullable|string',
            'phone' => 'required|string',
            'comment' => 'nullable|string',
            'coupon' => 'nullable|string',
            'payment_method' => 'required|in:cash,card',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $product = Product::find($validatedData['product_id']);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        $orderSum = $product->price * $quantity;

        if ($validatedData['delivery_method'] === 'delivery') {
            $orderSum += 10000;
        }


        $order = Order::create([
            'user_id' => auth()->id(),
            'name' => $validatedData['name'],
            'number' => $validatedData['number'],
            'city' => $validatedData['city'],
            'district' => $validatedData['district'],
            'delively_method' => $validatedData['delivery_method'],
            'town' => $validatedData['town'],
            'adres' => $validatedData['address'],
            'orient' => $validatedData['orient'] ?? '',
            'work_adres' => $validatedData['work_address'] ?? '',
            'phone' => $validatedData['phone'],
            'comment' => $validatedData['comment'] ?? '',
            'coupon' => $validatedData['coupon'] ?? '',
            'payment_method' => $validatedData['payment_method'],
            'sum' => $orderSum,
            'products' => json_encode([
                [
                    'id' => $productId,
                    'name' => $product->name,
                    'slug' => $this->generateSlug($product->name, $product->sku),
                    'brand' => $product->brendy,
                    'sku' => $product->sku,
                    'image' => $product->image,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'total_price' => $product->price * $quantity,
                ]
            ]),
            'status_id' => 1, // assuming default status is 1
        ]);

        return response()->json(['message' => 'Заказ успешно создан', 'order' => $order], 201);
    }

    public function showOrder($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json(['order' => $order]);
    }
}
