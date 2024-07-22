<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductFullResource;
use App\Http\Resources\ProductMinimalResource;
use App\Http\Services\ProductService;
use App\Models\Category;
use App\Models\Manufacturer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductService $productService;
    public function __construct(ProductService $productService){
        $this->productService = $productService;
    }

    public function showDisks(): JsonResponse
    {
        $category = Category::where('id', 369)->firstOrFail();

        $products = $category->products()->paginate(10);

        return response()->json([
           'category' => $category->name,
           'product' => ProductMinimalResource::collection($products),
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


    public function showTires(Request $request): JsonResponse
    {
        $category = Category::where('id', 370)->firstOrFail();
        $filteredProducts = $this->productService->tiresFilter($request);

        $manufacturers = Manufacturer::query()->paginate(10);
        $manufacturersCollection = $manufacturers->getCollection();
        $manufacturerNames = $manufacturersCollection->pluck('name');

        return response()->json([
            'category' => $category->name,
            'manufacturer' => $manufacturerNames,
            'products' => ProductMinimalResource::collection($filteredProducts),
            'pagination' => [
                'total' => $filteredProducts->total(),
                'per_page' => $filteredProducts->perPage(),
                'current_page' => $filteredProducts->currentPage(),
                'last_page' => $filteredProducts->lastPage(),
                'next_page_url' => $filteredProducts->nextPageUrl(),
                'prev_page_url' => $filteredProducts->previousPageUrl(),
            ],
        ]);
    }

    public function showOneTireWithSlug(Request $request, $slug): JsonResponse
    {

        return response()->json(['product' => ProductFullResource::collection()]);
    }
}
