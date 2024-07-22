<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductMinimalResource;
use App\Http\Services\ProductService;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected ProductService $productService;
    public function __construct(ProductService $productService){
        $this->productService = $productService;
    }
    public function index()
    {
        $categories = Category::where('published', 1)->get();
        return CategoryResource::collection($categories);
    }

    public function show($slug, Request $request): JsonResponse
    {
        $categories = Category::where('name',  $slug)->firstOrFail();

        $filteredProducts = $this->productService->tiresFilter($request);

        return response()->json([
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


}
