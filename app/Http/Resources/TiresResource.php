<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TiresResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'year' => $this->year,
            'name' => $this->name,
            'model' => $this->model,
            'price' => $this->price,
            'image' => $this->image,
            'radius'=> $this->radius,
            'weight' => $this->weight,
            'height' => $this->height,
            'season' => $this->season,
            'spikes' => $this->spikes,
            'index_n' => $this->index_n,
            'index_s' => $this->index_s,
            'country' => $this->country,
            'run_flat' => $this->run_flat,
        ];
    }
}
