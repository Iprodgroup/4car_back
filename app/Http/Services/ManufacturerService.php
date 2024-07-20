<?php

namespace App\Http\Services;

use App\Http\Resources\ManufacturerResource;
use App\Http\Resources\ProductMinimalResource;
use App\Models\Manufacturer;
use Illuminate\Http\JsonResponse;

class ManufacturerService
{
    public function showManufacturerWithProductAndPagination($slug): JsonResponse
    {
        $manufacturer = Manufacturer::where('name', $slug)->firstOrFail();

        $products = $manufacturer->products()->paginate(10);

        return response()->json([
            'manufacturer' => new ManufacturerResource($manufacturer),
            'products' => ProductMinimalResource::collection($products),
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
