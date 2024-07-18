<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [ 'name', 'category','vendor', 'height',
                            'diameter', 'weight', 'load_index', 'speed_index',
                            'model', 'run_flat', 'volume', 'season', 'spikes', 'width',
                            'price', 'price', 'overhang', 'count_bolt', 'spacing_bolt',
                            'hole', 'type', 'colour'];

    public function manufacturers(): BelongsToMany
    {
        return $this->belongsToMany(Manufacturer::class, 'product_manufacturer_mapping_models', 'products_id', 'manufacturer_id')
            ->withPivot('is_featured_product', 'display_order');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category_mapping_models', 'products_id', 'category_id')
            ->withPivot('is_featured_product', 'display_order');
    }


}
