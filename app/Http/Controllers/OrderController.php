<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        return $this->response(OrderResource::collection(auth()->user()->orders()->paginate(10)));
    }

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
            'status' => 'required',
            'tires' => 'required',
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
            'status' => $request->status,
            'tires' => $request->tires,
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
