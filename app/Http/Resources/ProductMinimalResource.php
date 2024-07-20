<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductMinimalResource extends JsonResource
{

    public function toArray(Request $request)
    {
        return [
          'id' => $this->id,
          'name' => $this->name,
          'price' => $this->price,
          'image' => $this->image,
        ];
    }
}
