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
                    'image' => 'https://test.4car.kz'.$product->image,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total_price' => $totalPrice,
                ];
                $detailedCart['total_price'] += $totalPrice;
            }
        }

        return $detailedCart;
    }

    public function syncWithFrontend(Request $request, array $productIds)
    {
        $cart = $request->session()->get('cart', []);

        foreach ($productIds as $productId) {
            if (Product::find($productId)) {
                if (isset($cart['products'][$productId])) {
                    $cart['products'][$productId]['quantity'] += 1;
                } else {
                    $cart['products'][$productId] = [
                        'product_id' => $productId,
                        'quantity' => 1,
                    ];
                }
            }
        }

        $request->session()->put('cart', $cart);
        return $cart;
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:0',
        ]);

        $cart = $request->session()->get('cart', []);
        $productId = $request->input('product_id');
        $newQuantity = $request->input('quantity');

        if (isset($cart['products'][$productId])) {
            if ($newQuantity > 0) {
                $cart['products'][$productId]['quantity'] = $newQuantity;
            } else {
                unset($cart['products'][$productId]);
            }
        }

        $request->session()->put('cart', $cart);

        return $cart;
    }

    public function getProductInCart(Request $request, int $productId)
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart['products'][$productId])) {
            $product = Product::find($productId);

            if ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => $product->brand,
                    'image' => 'https://test.4car.kz'.$product->image,
                    'quantity' => $cart['products'][$productId]['quantity'],
                    'price' => $product->price,
                    'total_price' => $product->price * $cart['products'][$productId]['quantity'],
                ];
            }
        }

        return null;
    }

}
