<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
          'name' => $this->name,
          'published' => $this->published,
          'description' => $this->description,
          'products' => ProductFullResource::collection($this->whenLoaded('products')),
        ];
    }
}