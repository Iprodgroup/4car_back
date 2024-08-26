<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductManufacturerMapping extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'manufacturer_id', 'is_featured_product', 'display_order'];
}
