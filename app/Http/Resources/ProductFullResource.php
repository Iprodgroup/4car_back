<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductFullResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'articul' => $this->sku,
            'brend' => $this->brendy,
            'season' => $this->sezony,
            'size_of_tires' => $this->razmer_shiny,
            'width' => $this->shirina_shin,
            'model' => $this->modeli,
            'run_flat' => $this->run_flat,
            'price' => $this->price,
            'indeks_nagruzki' => $this->indeks_nagruzki,
            'indeks_skorosti' => $this->indeks_skorosti,
            'image' => $this->image,

        ];
    }
}
