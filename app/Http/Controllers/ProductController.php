<?php
namespace App\Http\Controllers;

use App\Http\Resources\ProductFullResource;
use App\Http\Resources\ProductMinimalResource;
use App\Http\Services\ProductService;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
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

        $products = $category->products()->paginate(8);
//        dd($products->perPage());
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

    public function showTire($slug): JsonResponse
    {
        $skuPart = substr(strrchr($slug, '-p'), 2);

        // Extract the name part
        $namePart = str_replace('-p' . $skuPart, '', $slug);
        $namePart = str_replace('-', ' ', $namePart);

        // Replace hyphens back to spaces and slashes
        $namePart = str_replace('-', ' ', $namePart);
        $namePart = str_replace(' ', '/', $namePart);


        $product = Product::where('name', 'LIKE', "%$namePart%")->where('sku', $skuPart)->firstOrFail();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json(new ProductFullResource($product));
    }

    public function showTires(Request $request): JsonResponse
    {
        $category = Category::where('id', 370)->firstOrFail();
        $filteredProductsQuery = $this->productService->tiresFilter($request);
        $filteredProducts = $filteredProductsQuery->paginate(12);
        $productsForFilter = $this->productService->filtersAttributes();
        return response()->json([
            'category' => $category->name,
            'products' => ProductMinimalResource::collection($filteredProducts),
            'filter' => $productsForFilter,
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
