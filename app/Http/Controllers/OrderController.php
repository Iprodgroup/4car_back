<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Services\OrderService;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        return $this->response(OrderResource::collection(auth()->user()->orders()->paginate(10)));
    }

    public function store(OrderService $orderService, Request $urequest, OrderRequest $request): JsonResponse
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
