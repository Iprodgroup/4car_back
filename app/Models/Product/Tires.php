<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tires extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'model',
        'weight',
        'height',
        'radius',
        'spikes',
        'index_n',
        'index_s',
        'run_flat',
        'country',
        'year',
        'price',
        'image',
    ];
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'tires_id');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

}
