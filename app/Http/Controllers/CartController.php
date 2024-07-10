<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCartTires(Request $request)
    {
        $request->validate([
            'tires_id' => 'required|exists:tires,id',
            'quantity' => 'integer|min:1',
        ]);

        $user = $request->user();
        $cartItem = Cart::firstOrCreate([
            'user_id' => $user->id,
            'tires_id' => $request->tires_id,
        ], [
            'quantity' => $request->quantity ?? 1
        ]
        );
        $cartItem->load('tires');
        return new CartResource($cartItem);
    }

    public function addToCartDisks(Request $request)
    {
        $request->validate([
            'disk_id' => 'required|exists:disks,id',
            'quantity' => 'integer|min:1',
        ]);

        $user = $request->user();
        $cartItem = Cart::firstOrCreate([
            'user_id' => $user->id,
            'disk_id' => $request->disk_id,
        ],
        [
            'quantity' => $request->quantity ?? 1
        ]);

        $cartItem->load('disks');
        return new CartResource($cartItem);
    }

    public function cleanOneElementFromCart(Request $request, $id)
    {
        $user = $request->user();
        $tire_id = $request->tires_id;

        $cartItem = Cart::where('user_id', $user->id)->where('tires_id', $tire_id)->delete();

        if ($cartItem) {
            $cartItem->delete();
            return $this->success('Товар успешно удален из корзины', 200);
        } else {
            return $this->error('Произошла ошибка при удалении товара', 404);
        }
    }

    public function cleanCart(Request $request)
    {
        $user = $request->user();
        $cartItem = Cart::where('user_id', $user->id)->delete();
        return $this->success('Корзина очищена', 200);
    }
    public function getCart(Request $request)
    {
        $user = $request->user();
        $cartItem = Cart::where('user_id', $user->id)->get();

        $totalPrice = $cartItem->sum(function ($cartItem)
        {
            return $cartItem->total_price;
        });

        return $this->response([
            'data' => CartResource::collection($cartItem),
            'total_price' => $totalPrice,
        ]);
    }



}
