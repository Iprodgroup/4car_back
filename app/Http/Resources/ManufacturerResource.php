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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->generateSlug($this->name),
            'description' => $this->description,
            'image' => "https://74f07b5f-3d2a-44e0-ab92-49f88604e3b9.tunnel4.com/" . $this->picture_id,
            'products' => ProductMinimalResource::collection($this->whenLoaded('products'))
        ];
    }
}
