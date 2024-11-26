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
          'slug' => $this->manufacturer_part_number,
          'price' => $this->price,
          'quantity' => $this->stock_quantity,
          'image' => 'https://test.4car.kz/'.$this->image,
        ];
    }
}
