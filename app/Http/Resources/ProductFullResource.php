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
        $images = ($this->id == 192051) ? [
            'https://4car.kz/images/thumbs/0177179_iny-boto-brawn-br02-155-r12c-8886r-8pr_510.jpeg',
            'https://4car.kz/images/thumbs/0177180_iny-boto-brawn-br02-155-r12c-8886r-8pr_510.jpeg',
            'https://4car.kz/images/thumbs/0177181_iny-boto-brawn-br02-155-r12c-8886r-8pr_510.jpeg',
            'https://4car.kz/images/thumbs/0177182_iny-boto-brawn-br02-155-r12c-8886r-8pr_510.jpeg',
            'https://4car.kz/images/thumbs/0177183_iny-boto-brawn-br02-155-r12c-8886r-8pr_510.jpeg'
        ] : [];
        return [
            'id' => $this->id,
            'category' =>  $this->categories->pluck('name'),
            'name' => $this->name,
            'sku' => $this->sku,
            'slug' => $this->manufacturer_part_number,
            'short_description' => $this->short_description,
            'full_description' => $this->full_description,
            'meta_description' => $this->full_description,
            'meta_title' => $this->meta_title,
            'model' => $this->modeli,
            'articul' => $this->sku,
            'brand' => $this->brendy,
            'brand_slug' => $this->generateSlug($this->brendy),
            'season' => $this->vidy_nomenklaturi,
            'size_of_tires' => $this->razmer_shiny,
            'height' => $this->vysota_shin,
            'diameter' => $this->diametr_shin,
            'width' => $this->shirina_shin,
            'run_flat' =>  $this->run_flat ? 'Да' : 'Нет',
            'price' => $this->price,
            'spikes' => $this->shipy ? 'Есть' : 'Нет',
            'indeks_nagruzki' => $this->indeks_nagruzki,
            'indeks_skorosti' => $this->indeks_skorosti,
            'otverstiya' => $this->otverstiya,
            'rasstoyaniya' => $this->rasstoyaniya,
            'kolichestvo_boltov' => $this->kolichestvo_boltov,
            'image' => 'https://test.4car.kz'. $this->image,
            'images' => $images,
            'similar_products' => $this->getSimilarProducts(),
        ];
    }

    private function getSimilarProducts()
    {
        $similarProducts = Product::query()
            ->where('modeli', $this->modeli)
            ->where('id', '!=', $this->id)
            ->where('image', '!=', null)
            ->where('price', '>', 0)
            ->limit(10)
            ->get();

        return $similarProducts->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->manufacturer_part_number,
                'image' => "https://test.4car.kz".$product->image,
                'short_description' => $product->short_description,
                'price' => $product->price,
            ];
        });

    }
}
