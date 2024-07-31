<?php
namespace App\Http\Services\Product;

use App\Http\Resources\ManufacturerResource;
use App\Models\Product\Manufacturer;

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
