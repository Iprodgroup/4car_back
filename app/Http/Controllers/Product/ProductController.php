<?php
namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductFullResource;
use App\Services\Product\ProductService;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    use PaginationTrait;
    protected ProductService $productService;
    public function __construct(ProductService $productService){
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

    public function showAllDisks(): JsonResponse
    {
       $disks = $this->productService->getAllDisks();
       return response()->json($disks);
    }

    public function showDiskBySlug($slug): JsonResponse
    {
        $product = $this->productService->showDiskBySlug($slug);
        return response()->json(new ProductFullResource($product));
    }
}
