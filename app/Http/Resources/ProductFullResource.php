<?php

namespace App\Http\Resources;

use App\Traits\SlugTrait;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductFullResource extends JsonResource
{
    use SlugTrait;
    public function toArray(Request $request): array
    {
        $baseUrl = 'https://test.4car.kz/storage/users/shina.png';
        return [
            'name' => $this->name,
            'sku' => $this->sku,
            'slug' => $this->generateSlug($this->name),
            'short_description' => $this->short_description,
            'full_description' => $this->full_description,
            'meta_description' => $this->full_description,
            'meta_title' => $this->meta_title,
            'model' => $this->modeli,
            'articul' => $this->sku,
            'brend' => $this->brendy,
            'season' => $this->sezony,
            'size_of_tires' => $this->razmer_shiny,
            'height' => $this->vysota_shin,
            'diameter' => $this->diametr_shin,
            'width' => $this->shirina_shin,
            'run_flat' => $this->run_flat,
            'price' => $this->price,
            'spikes' => $this->shipy,
            'indeks_nagruzki' => $this->indeks_nagruzki,
            'indeks_skorosti' => $this->indeks_skorosti,
            'image' => $baseUrl,
            'similar_products' => $this->getSimilarProducts(),
        ];
    }

    private function getSimilarProducts()
    {
        $similarProducts = Product::query()
            ->where('modeli', $this->modeli) // Условие для модели
            ->where('id', '!=', $this->id)
            ->limit(10)
            ->get();

        return $similarProducts->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $this->generateSlug($product->name),
                'image' => "https://test.4car.kz$product->image",
                'short_description' => $product->short_description,
                'price' => $product->price,
            ];
        });

    }
}
