<?php
namespace App\Services\Product;

use App\Traits\SlugTrait;
use App\Traits\PaginationTrait;
use App\Models\Product\Manufacturer;
use App\Http\Resources\ManufacturerResource;

class ManufacturerService
{
    use PaginationTrait, SlugTrait;
    public function showManufacturerWithProductAndPagination($slug): ManufacturerResource
    {
        $manufacturer = Manufacturer::with('products')
            ->where('name', $slug)
            ->firstOrFail();
        return new ManufacturerResource($manufacturer);
    }

    public function getManufacturers(): array
    {
        $manufacturers = Manufacturer::query();
        $manufacturers = $manufacturers->paginate(18);
        $query = [
            'data' => ManufacturerResource::collection($manufacturers),
            'pagination' => $this->paginate($manufacturers)
        ];
        return $query;
    }

    public function getMainPageManufacturers()
    {
        $manufacturers = Manufacturer::query()
            ->where('picture_id', '!=', 'storage/image/undo.png')
            ->limit(15)
            ->get();

        return ManufacturerResource::collection($manufacturers);
    }

}
