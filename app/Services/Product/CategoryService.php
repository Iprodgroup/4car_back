<?php

namespace App\Services\Product;

use App\Http\Resources\ProductMinimalResource;
use App\Models\Product\Category;
use App\Traits\PaginationTrait;
use Illuminate\Http\Request;

class CategoryService
{
    use PaginationTrait;
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
            'pagination' => $this->paginate($filteredProducts),
        ];
    }
}
