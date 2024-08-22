<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Models extends Model
{
    use HasFactory;
    protected $fillable = ['brand_id', 'name', 'type'];
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
