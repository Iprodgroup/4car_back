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
        return [
          'id' => $this->id,
          'sku' => $this->sku,
          'name' => $this->name,
          'brand' => $this->brendy,
          'slug' => $this->generateSlug($this->name, $this->sku),
          'price' => $this->price,
          'quantity' => $this->stock_quantity,
          'image' => 'https://test.4car.kz/'.$this->image,
        ];
    }
    protected function generateProductSlug(string $name, string $sku): string
    {
        $namePart = $this->generateSlug($name);
        $skuPart = 'p' . $sku;
        return "$namePart-$skuPart";
    }
}
