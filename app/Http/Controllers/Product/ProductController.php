<?php
namespace App\Http\Controllers\Product;

use App\Traits\SlugTrait;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Product\ProductService;
use App\Http\Resources\ProductFullResource;
use App\Http\Resources\ProductMinimalResource;

class ProductController extends Controller
{
    use PaginationTrait, SlugTrait;
    protected ProductService $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function filter(Request $request)
    {
        $query = Product::query();

        if ($request->has('season')) {
            $query->where('sezony', $request->season);
        }

        if ($request->has('diameter')) {
            $query->where('diametr_shin', $request->diameter);
        }

        if ($request->has('width')) {
            $query->where('shirina_shin', $request->width);
        }

        if ($request->has('run_flat')) {
            $query->where('run_flat', $request->run_flat);
        }

        if ($request->has('spikes')) {
            $query->where('shipy', $request->spikes);
        }

        if ($request->has('indeks_nagruzki')) {
            $query->where('indeks_nagruzki', $request->indeks_nagruzki);
        }

        if ($request->has('indeks_skorosti')) {
            $query->where('indeks_skorosti', $request->indeks_skorosti);
        }

        $products = $query->get();

        return ProductMinimalResource::collection($products);
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

    public function showProductBySlug($slug): JsonResponse
    {
        $product = $this->productService->showProductBySlug($slug);
        return response()->json(new ProductFullResource($product));
    }

    public function getBestSellingProducts()
    {
        $products = $this->productService->getBestSalesProducts();
        return response()->json(ProductMinimalResource::collection($products));
    }

    public function getModelsByBrand(Request $request)
    {
        $result = $this->productService->modelsByBrand($request);
        return response()->json($result);
    }

    public function getYearsByModel(Request $request)
    {
        $result = $this->productService->yearsByModel($request);
        return response()->json($result);
    }

    public function getModificationsByModelAndYear(Request $request)
    {
        $result = $this->productService->modificationByModelAndYear($request);
        return response()->json($result);
    }

    public function getOptionsByModification(Request $request)
    {
        $result = $this->productService->filterByModification($request);
        return response()->json($result);
    }

    public function searchDisks(Request $request)
    {
        if ($request->has(['shirina', 'dia'])) {
            $shirina = $request->input('shirina');
            $dia = $request->input('dia');

            $newRequest = new Request([
                'shirina' => $shirina,
                'dia' => $dia
            ]);

            $disks = $this->productService->searchSimilarProducts($newRequest);
            return response()->json($disks);
        }

        return response()->json(['error' => 'Характеристики не выбраны'], 400);
    }

    public function getOptionsByModificationTires(Request $request)
    {
        $result = $this->productService->optionsByModificationForTires($request);
        return response()->json($result);
    }
}
