<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product\Order;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Services\Product\CartService;
use App\Services\Product\OrderService;

class OrderController extends Controller
{
    protected $orderService, $cartService;

    public function __construct(OrderService $orderService, CartService  $cartService)
    {
        $this->orderService = $orderService;
        $this->cartService = $cartService;
        $this->middleware('auth:sanctum');
    }

    public function getUserOrders()
    {
        return $this->orderService->getOrders();
    }
    public function createOrderWithoutCart(Request $request)
    {
        return $this->orderService->createOrderWithoutCart($request);
    }
    public function placeOrder(Request $request): JsonResponse
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'delivery_method' => 'required|in:delivery,pickup',
            'town' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'orient' => 'required|string|max:255',
            'work_address' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255',
            'comment' => 'nullable|string',
            'coupon' => 'nullable|string|max:255',
            'payment_method' => 'required|in:cash,card',
        ]);


        $cart = $this->cartService->getCart($request);

        if (empty($cart['items'])) {
            return response()->json(['error' => 'Корзина пуста!'], 400);
        }
        $orderSum = $cart['total_price'];

        if ($validatedData['delivery_method'] === 'delivery') {
            $orderSum += 10000;
        }

        $order = new Order();
        $order->user_id = $request->user()->id ?? null; // Идентификатор пользователя, если он авторизован
        $order->name = $validatedData['name'];
        $order->number = $validatedData['number'];
        $order->city = $validatedData['city'];
        $order->district = $validatedData['district'];
        $order->delively_method = $validatedData['delivery_method'];
        $order->town = $validatedData['town'];
        $order->adres = $validatedData['address'];
        $order->orient = $validatedData['orient'];
        $order->work_adres = $validatedData['work_address'];
        $order->phone = $validatedData['phone'];
        $order->comment = $validatedData['comment'];
        $order->coupon = $validatedData['coupon'];
        $order->payment_method = $validatedData['payment_method'];
        $order->sum = $orderSum;
        $order->products = json_encode($cart['items']);
        $order->status_id = 1;

        $order->save();
        $request->session()->forget('cart');

        return response()->json(['success' => 'Заказ успешно оформлен!', 'order_id' => $order->id], 201);
    }
    public function show(Order $order): JsonResponse
    {
        return response()->json(new OrderResource($order));
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete');
        $order->delete();
        return 1;
    }
}
