<?php

namespace App\Services\Product;

use Illuminate\Http\Request;
use App\Traits\PaginationTrait;
use App\Models\Product\Category;
use App\Http\Resources\ProductMinimalResource;

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
