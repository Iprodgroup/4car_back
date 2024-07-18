<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductManufacturerMappingModel extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'manufacturer_id', 'is_featured_product', 'display_order'];
}
