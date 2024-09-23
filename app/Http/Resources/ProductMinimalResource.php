<?php

namespace App\Http\Resources;

use App\Traits\SlugTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductMinimalResource extends JsonResource
{
    use SlugTrait;
    public function toArray(Request $request)
    {
        $images = json_decode($this->image);
        $imageUrls = [];

        if (is_array($images)) {
            foreach ($images as $image) {
                $imageUrls[] = 'https://test.4car.kz/' . $image;
            }
        } else {
            $imageUrls[] = 'https://test.4car.kz/' . $images;
        }
        return [
          'id' => $this->id,
          'sku' => $this->sku,
          'name' => $this->name,
          'brand' => $this->brendy,
          'slug' => $this->generateSlug($this->name, $this->sku),
          'price' => $this->price,
          'image' => $imageUrls,
        ];
    }

    protected function generateProductSlug(string $name, string $sku): string
    {
        $namePart = $this->generateSlug($name);
        $skuPart = 'p' . $sku;
        return "$namePart-$skuPart";
    }
}
