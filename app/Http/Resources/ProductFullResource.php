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
            'short_description' => $this->short_description,
            'full_description' => $this->full_description,
            'meta_description' => $this->full_description,
            'meta_title' => $this->meta_title,
            'model' => $this->modeli,
            'articul' => $this->sku,
            'brend' => $this->brendy,
            'season' => $this->sezony,
            'size_of_tires' => $this->razmer_shiny,
            'diameter' => $this->diametr_shin,
            'width' => $this->shirina_shin,
            'run_flat' => $this->run_flat,
            'price' => $this->price,
            'spikes' => $this->shipy,
            'indeks_nagruzki' => $this->indeks_nagruzki,
            'indeks_skorosti' => $this->indeks_skorosti,
            'image' => $this->image,

        ];
    }
}
