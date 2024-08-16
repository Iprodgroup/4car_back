<?php

namespace App\Services\Product;

use Illuminate\Http\Request;
use App\Models\Product\Product;

class CartService
{
    public function addProductToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1',
        ]);

        $cart = $request->session()->get('cart', []);
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        if (isset($cart['products'][$productId])) {
            $cart['products'][$productId]['quantity'] += $quantity;
        } else {
            $cart['products'][$productId] = [
                'product_id' => $productId,
                'quantity' => $quantity,
            ];
        }

        $request->session()->put('cart', $cart);
        return $cart;
    }

    public function getCart(Request $request): array
    {
        $cart = $request->session()->get('cart', []);
        $detailedCart = [
            'items' => [],
            'total_price' => 0,
        ];

        foreach ($cart['products'] ?? [] as $productId => $item) {
            $product = Product::find($productId);

            if ($product) {
                $totalPrice = $product->price * $item['quantity'];

                $detailedCart['items'][] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => $product->brand,
                    'image' => $product->image,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total_price' => $totalPrice,
                ];
                $detailedCart['total_price'] += $totalPrice;
            }
        }

        return $detailedCart;
    }

}
