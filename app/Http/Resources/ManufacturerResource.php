<?php

namespace App\Http\Resources;

use App\Traits\SlugTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManufacturerResource extends JsonResource
{
    use SlugTrait;
    public function toArray(Request $request): array
    {
        $baseUrl = 'https://8eb0-93-188-86-71.ngrok-free.app/storage/users/ass.jpeg';

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->generateSlug($this->name),
            'description' => $this->description,
            'image' => $baseUrl,
            'products' => ProductMinimalResource::collection($this->whenLoaded('products'))
        ];
    }
}
