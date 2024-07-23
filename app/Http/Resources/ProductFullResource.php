<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductFullResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $baseUrl = 'https://0b70-93-188-86-71.ngrok-free.app/storage/users/shina.png';
        return [
            'id' => $this->id,
            'slug' => $this->generateSlug($this->name, $this->sku),
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
            'image' => $baseUrl,
        ];
    }

    private function generateSlug($name, $article)
    {
        return \Str::slug($name) . '-p' . $article;
    }
}
