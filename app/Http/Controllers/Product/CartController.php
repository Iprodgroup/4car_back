<?php

namespace App\Http\Controllers\Product;

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
        return $this->success('Товары успешно добавлены в корзину!', $cart);
    }

    public function cleanCart(Request $request)
    {
        $request->session()->forget('cart');
        return $this->success('Корзина успешно очищена!');
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
}