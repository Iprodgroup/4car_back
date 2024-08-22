<?php
namespace App\Services\Product;

use App\Traits\PaginationTrait;
use App\Models\Product\Manufacturer;
use App\Http\Resources\ManufacturerResource;

class ManufacturerService
{
    use PaginationTrait;
    public function showManufacturerWithProductAndPagination($slug)
    {
        $manufacturer = Manufacturer::with('products')
            ->where('name', $slug)
            ->firstOrFail();
        return new ManufacturerResource($manufacturer);
    }

    public function getManufacturers()
    {
        $manufacturers = Manufacturer::query();
        $manufacturers = $manufacturers->paginate(18);
        $query = [
            'data' => ManufacturerResource::collection($manufacturers),
            'pagination' => $this->paginate($manufacturers)
        ];
        return $query;
    }
}
