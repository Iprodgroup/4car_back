<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = ['name', 'description', 'category_templated_id',
        'meta_keywords', 'meta_description', 'meta_title', 'parent_category_id',
        'picture_id','page_size','allow_customers_to_select_page_size', 'page_resize_options',
        'price_ranges', 'show_on_homepage', 'include_in_top_menu', 'subject_to_acl',
        'limited_to_stories', 'published', 'deleted', 'display_order'
    ];

    public function products(): BelongsToMany
    {
        return $this->BelongsToMany(Product::class, 'product_category_mappings', 'category_id', 'products_id')
                    ->withPivot('is_featured_product', 'display_order');
    }
}
