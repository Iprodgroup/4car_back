<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function carts()
    {
        return $this->hasMany(Cart::class, 'tires_id');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

}
