<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class Models extends Model
{
    use HasFactory, Searchable;
    protected $fillable = ['brand_id', 'name', 'type'];
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
