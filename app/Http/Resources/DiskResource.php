<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'size' => $this->size,
            'brand'=> $this->brand,
            'model'=> $this->model,
            'number_of_holes' => $this->number_of_holes,
            'size_of_holes' => $this->size_of_holes,
            'width' => $this->width,
            'diametr' => $this->diametr,
            'departure' => $this->departure,
            'tco' => $this->tco,
            'price'=> $this->price,
            'image' => $this->image,
        ];
    }
}
