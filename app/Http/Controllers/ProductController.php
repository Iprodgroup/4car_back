<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductFullResource;
use App\Models\Category;
use App\Models\Disk;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{

    public function showDisks(): JsonResponse
    {
        $category = Category::where('id', 370)->firstOrFail();

        $products = $category->products()->paginate(10);

        return response()->json([
           'category' => $category->name,
           'product' => '',
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'next_page_url' => $products->nextPageUrl(),
                'prev_page_url' => $products->previousPageUrl(),
            ],
        ]);
    }
    public function showTires(): JsonResponse
    {
        $category = Category::where('id', 369)->firstOrFail();

        $products = $category->products()->paginate(10);

        return response()->json([
            'category' => $category->name,
            'product' => ProductFullResource::collection($products),
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'next_page_url' => $products->nextPageUrl(),
                'prev_page_url' => $products->previousPageUrl(),
            ],
        ]);
    }


}
