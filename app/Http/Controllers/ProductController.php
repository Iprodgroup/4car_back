<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function showDisks(): JsonResponse
    {
        $products = Product::where('category', 'disks')->get;
        return $this->response($products);
    }

    public function showTires(): JsonResponse
    {
        $products = Product::where('category', ['tires_summer', 'tires_winter'])->get;

        $products->transform(function ($product) {
            $product->category = 'tires';
            return $product;
        });

        return response()->json($products);
    }

}
