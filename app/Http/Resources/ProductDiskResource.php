<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDiskResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'artikul' => $this->sku,
            'price' => $this->price,

        ];
    }
}
