<?php

namespace App\Http\Resources;

use App\Traits\SlugTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    use SlugTrait;
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->generateSlug($this->title),
            'title' => $this->title,
            'text' => $this->text,
            'description' => $this->description,
            'date' => $this->date,
            'image' => $this->image,
        ];
    }
}
