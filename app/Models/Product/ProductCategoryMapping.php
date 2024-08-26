<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategoryMapping extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'category_id', 'is_featured_product', 'display_order'];
}
