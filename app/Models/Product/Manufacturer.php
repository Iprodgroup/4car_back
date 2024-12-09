<?php

namespace App\Models\Product;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Manufacturer extends Model
{
    use HasFactory;
    protected $primaryKey = 'id'; // Убедитесь, что это указано
    public $incrementing = true; // Укажите, что поле `id` автоматически инкрементируется
    protected $keyType = 'int';
    protected $fillable = ['name', 'description',
        'manufacturer_template_id', 'meta_keywords', 'meta_description',
        'meta_title', 'picture_id', 'page_size', 'allow_customers_to_select_page_size',
        'page_resize_options', 'price_ranges', 'subject_to_acl',
        'limited_to_stories','published', 'deleted', 'display_order'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_manufacturer_mapping', 'manufacturer_id', 'products_id')
            ->withPivot('is_featured_product', 'display_order');
    }
    public function getShortDescriptionAttribute(): string
    {
        return Str::words($this->description, 15, '...');
    }
}
