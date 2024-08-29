<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product\Order;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Services\Product\OrderService;

class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->middleware('auth:sanctum');
    }

    public function getUserOrders()
    {
        return $this->orderService->getOrders();
    }

    public function createFromCart(Request $request): JsonResponse
    {
        try {
            $order = $this->orderService->createOrderFromCart($request);

            if ($order->payment_method === 'card') {
                return response()->json(['redirect' => route('payment.page', ['order' => $order->id])]);
            }
            return response()->json(['message' => 'Заказ успешно оформлен', 'order' => $order], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function createInstantOrder(OrderRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->createInstantOrder($request->validated());

            if ($order->payment_method === 'card') {
                return response()->json(['redirect' => route('payment.page', ['order' => $order->id])]);
            }

            return response()->json(['message' => 'Заказ успешно оформлен', 'order' => $order], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function show(Order $order): JsonResponse
    {
        return $this->response(new OrderResource($order));
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete');
        $order->delete();
        return 1;
    }
}
