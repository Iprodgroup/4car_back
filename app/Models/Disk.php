<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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

    public function carts()
    {
        return $this->hasMany(Cart::class, 'disk_id');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
