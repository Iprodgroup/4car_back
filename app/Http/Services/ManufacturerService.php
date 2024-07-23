<?php
namespace App\Http\Services;

use App\Http\Resources\ManufacturerResource;
use App\Models\Manufacturer;
use Illuminate\Http\JsonResponse;

class ManufacturerService
{
    public function showManufacturerWithProductAndPagination($slug)
    {
        $manufacturer = Manufacturer::with('products')
            ->where('name', $slug)
            ->firstOrFail();
        return new ManufacturerResource($manufacturer);
    }
}
