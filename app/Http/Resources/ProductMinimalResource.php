<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ProductMinimalResource extends JsonResource
{
    public function toArray(Request $request)
    {
        $baseUrl = 'https://0b70-93-188-86-71.ngrok-free.app/storage/users/shina.png';

        return [
          'id' => $this->id,
          'slug' => $this->generateSlug($this->name, $this->sku),
          'name' => $this->name,
          'price' => $this->price,
          'image' => $baseUrl,
        ];
    }

    protected function generateSlug(string $name): string
    {
        $namePart = Str::slug(str_replace('/', '-', $name), '-');
        $sku = 'p' . $this->sku;
        return "$namePart-$sku";
    }
}
