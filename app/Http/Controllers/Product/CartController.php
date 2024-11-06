<?php

namespace App\Http\Controllers\Product;

use App\Models\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Product\CartService;

class CartController extends Controller
{
    public function getCart(Request $request, CartService $cartService): JsonResponse
    {
        $detailedCart = $cartService->getCart($request);
        return response()->json($detailedCart);
    }

    public function addToCartProducts(Request $request, CartService  $cartService): JsonResponse
    {
        $cart = $cartService->addProductToCart($request);
        return response()->json(['Товары успешно добавлены в корзину!', $cart]);
    }

    public function cleanCart(Request $request)
    {
        $request->session()->forget('cart');
        return response()->json('Корзина успешно очищена!');
    }

    public function cleanOneElementFromCart(Request $request, $type, $id)
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$type][$id])) {
            unset($cart[$type][$id]);
            $request->session()->put('cart', $cart);

            return response()->json(['message' => 'Товар успешно удален из корзины', 'cart' => $cart]);
        }

        return response()->json(['message' => 'Произошла ошибка при удалении товара'], 404);
    }

    public function syncCartWithFrontend(Request $request, CartService $cartService): JsonResponse
    {
        $productIds = $request->input('ids', []);
        $cart = $cartService->syncWithFrontend($request, $productIds);
        return response()->json(['message' => 'Корзина успешно обновлена', 'cart' => $cart]);
    }

    public function updateQuantity(Request $request, CartService $cartService): JsonResponse
    {
        $updatedCart = $cartService->updateQuantity($request);
        return response()->json([
            'message' => 'Количество товара успешно обновлено!',
            'cart' => $updatedCart
        ]);
    }

    public function getProductInCart(Request $request, int $productId)
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart['products'][$productId])) {
            $product = Product::find($productId);

            if ($product) {
                return [
                    'id' => $product->id,
                    'sku' => $product->sku,
                    'name' => $product->name,
                    'brand' => $product->brand,
                    'image' => $product->image,
                    'quantity' => $cart['products'][$productId]['quantity'],
                    'price' => $product->price,
                    'total_price' => $product->price * $cart['products'][$productId]['quantity'],
                ];
            }
        }

        return null;
    }
}
