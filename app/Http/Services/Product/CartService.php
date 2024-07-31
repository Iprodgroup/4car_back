<?php

namespace App\Http\Services\Product;

use App\Models\Product\Disk;
use App\Models\Product\Tires;
use Illuminate\Http\Request;

class CartService
{
    public function addTires(Request $request)
    {
        $request->validate([
            'tires_id' => 'required|exists:tires,id',
            'quantity' => 'integer|min:1',
        ]);

        $cart = $request->session()->get('cart', []);
        $tiresId = $request->input('tires_id');
        $quantity = $request->input('quantity', 1);

        if (isset($cart['tires'][$tiresId])) {
            $cart['tires'][$tiresId]['quantity'] += $quantity;
        } else {
            $cart['tires'][$tiresId] = [
                'tires_id' => $tiresId,
                'quantity' => $quantity,
            ];
        }
         $request->session()->put('cart', $cart);
        return $cart;
    }

    public function addDisks(Request $request)
    {
        $request->validate([
            'disk_id' => 'required|exists:disks,id',
            'quantity' => 'integer|min:1',
        ]);

        $cart = session('cart', []);
        $diskId = $request->disk_id;
        $quantity = $request->input('quantity', 1);

        if (isset($cart['disks'][$diskId])) {
            $cart['disks'][$diskId]['quantity'] += $quantity;
        } else {
            $cart['disks'][$diskId] = [
                'disk_id' => $diskId,
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

        foreach ($cart as $type => $items) {
            foreach ($items as $item) {
                if ($type === 'tires') {
                    $product = Tires::find($item['tires_id']);
                } else {
                    $product = Disk::find($item['disk_id']);
                }

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
        }
        return $detailedCart;
    }


}
