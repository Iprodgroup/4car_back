<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TiresResource extends JsonResource
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
            'model' => $this->model, 
            'weight' => $this->weight,  
            'height' => $this->height, 
            'diametr'=> $this->diametr,
            'season' => $this->season, 
            'spikes' => $this->spikes, 
            'index_n' => $this->index_n, 
            'index_s' => $this->index_s, 
            'run_flat' => $this->run_flat,
            'image' => $this->image,
        ];
    }
}
