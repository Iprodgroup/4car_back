<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManufacturerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $baseUrl = 'https://c3b1-93-188-86-71.ngrok-free.app/storage/users/ass.jpeg';

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $baseUrl,
            'products' => ProductMinimalResource::collection($this->whenLoaded('products'))
        ];
    }
}
