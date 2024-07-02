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
            'tires_id' => 'required|exists:disks,id',
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
        return new CartResource($cartItem);
    }

    public function getCart(Request $request)
    {
        $user = $request->user();
        $cartItem = Cart::where('user_id', $user->id)->get();
        return CartResource::collection($cartItem);
    }

}
