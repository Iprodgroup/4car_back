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
        $baseUrl = 'https://test.4car.kz/storage/users/ass.jpeg';

        return [
          'id' => $this->id,
          'sku' => $this->sku,
          'name' => $this->name,
          'slug' => $this->generateSlug($this->name),
          'price' => $this->price,
          'image' => $baseUrl,
        ];
    }

    protected function generateProductSlug(string $name, string $sku): string
    {
        $namePart = $this->generateSlug($name);
        $skuPart = 'p' . $sku;
        return "$namePart-$skuPart";
    }
}
