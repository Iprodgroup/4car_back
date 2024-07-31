<?php

namespace App\Http\Services\Product;

use Illuminate\Http\Request;
use App\Models\Product\Category;
use App\Http\Resources\ProductMinimalResource;

class CategoryService
{
    protected ProductService $productService;
    public function __construct(ProductService $productService){
        $this->productService = $productService;
    }
    public function showCategoryBySlug($slug, Request $request)
    {
        $categories = Category::where('name',  $slug)->firstOrFail();

        $filteredProducts = $this->productService->tiresFilter($request)->paginate(10);

        return [
            'products' => ProductMinimalResource::collection($filteredProducts),
            'pagination' => [
                'total' => $filteredProducts->total(),
                'per_page' => $filteredProducts->perPage(),
                'current_page' => $filteredProducts->currentPage(),
                'last_page' => $filteredProducts->lastPage(),
                'next_page_url' => $filteredProducts->nextPageUrl(),
                'prev_page_url' => $filteredProducts->previousPageUrl(),
            ],
        ];
    }
}
