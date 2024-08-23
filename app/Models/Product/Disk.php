<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Disk extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'size',
        'brand',
        'model',
        'number_of_holes',
        'size_of_holes',
        'width', 'diametr', 'departure',
        'tco', 'price', 'image',
    ];

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'disk_id');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
