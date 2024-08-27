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
        //return OrderResource::collection($orders);
    }

    public function storeUserOrder(OrderService $orderService, Request $urequest, OrderRequest $request): JsonResponse
    {
        $order = $orderService->getProductsFromCartToOrder($urequest, $request);
        return $this->success('Заказ успешно оформлен', $order);
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
