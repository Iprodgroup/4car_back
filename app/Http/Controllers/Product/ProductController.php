<?php
namespace App\Http\Controllers\Product;

use App\Traits\SlugTrait;
use Illuminate\Http\Request;
use App\Traits\PaginationTrait;
use App\Models\Product\Product;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Product\ProductService;
use App\Http\Resources\ProductFullResource;


class ProductController extends Controller
{
    use PaginationTrait, SlugTrait;
    protected ProductService $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function showTireWithSlug($slug): JsonResponse
    {
        $product = $this->productService->showTireBySlug($slug);
        return response()->json(new ProductFullResource($product));
    }

    public function showAllTires(Request $request): JsonResponse
    {
        $tires = $this->productService->getAllTires($request, $this->productService);
        return response()->json($tires);
    }

    public function showAllDisks(Request $request): JsonResponse
    {
       $disks = $this->productService->getAllDisks($request, $this->productService);
       return response()->json($disks);
    }

    public function showDiskBySlug($slug): JsonResponse
    {
        $product = $this->productService->generateSlug($slug);
        return response()->json(new ProductFullResource($product));
    }

    public function showProductBySlug($slug): JsonResponse
    {
        $product = Product::all()->first(function($productItem) use ($slug) {
            return $this->generateSlug($productItem->title) === $slug;
        });
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json(new ProductFullResource($product));
    }
}
