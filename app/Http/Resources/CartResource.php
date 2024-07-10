<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'tires' => new TiresResource($this->whenLoaded('tires')),
            'disk' => new DiskResource($this->whenLoaded('disk')),
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
        ];
    }
}
