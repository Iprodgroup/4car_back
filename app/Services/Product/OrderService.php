<?php

namespace App\Services\Product;

use App\Models\Product\Order;
use App\Models\Product\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
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


    public function createOrderFromCart($request)
    {
        $user = $request->user(); // Предполагаем, что пользователь аутентифицирован
        $cart = $request->session()->get('cart', []);

        if (empty($cart['products'])) {
            throw new \Exception('Корзина пуста');
        }

        $orderData = [
            'user_id' => $user->id,
            'name' => $request->name,
            'number' => $request->number,
            'city' => $request->city,
            'district' => $request->district,
            'delivery_method' => $request->delivery_method,
            'town' => $request->town,
            'adres' => $request->adres,
            'orient' => $request->orient,
            'work_adres' => $request->work_adres,
            'phone' => $request->phone,
            'comment' => $request->comment,
            'coupon' => $request->coupon,
            'payment_method' => $request->payment_method,
            'status_id' => 1, // Предположим, что 1 - это статус "новый заказ"
            'sum' => $this->calculateTotal($cart),
            'products' => json_encode($cart['products'])
        ];

        DB::beginTransaction();
        try {
            $order = Order::create($orderData);

            foreach ($cart['products'] as $productItem) {
                $product = Product::find($productItem['product_id']);
                if ($product) {
                    $order->products()->attach($product->id, ['quantity' => $productItem['quantity']]);
                }
            }

            $request->session()->forget('cart'); // Очищаем корзину
            DB::commit();

            return $order;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Не удалось создать заказ: ' . $e->getMessage());
        }
    }

    public function createInstantOrder(array $orderData)
    {
        $product = Product::find($orderData['product_id']);
        if (!$product) {
            throw new \Exception('Продукт не найден');
        }

        $orderData['sum'] = $product->price * $orderData['quantity']; // Цена одного товара умноженная на количество
        $orderData['products'] = json_encode([['product_id' => $orderData['product_id'], 'quantity' => $orderData['quantity']]]);

        DB::beginTransaction();
        try {
            $order = Order::create($orderData);

            $order->products()->attach($product->id, ['quantity' => $orderData['quantity']]);

            DB::commit();

            return $order;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Не удалось создать заказ: ' . $e->getMessage());
        }
    }

    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart['products'] as $productItem) {
            $product = Product::find($productItem['product_id']);
            if ($product) {
                $total += $product->price * $productItem['quantity'];
            }
        }
        return $total;
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
