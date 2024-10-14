<?php

namespace App\Models\Product;

use App\Models\Tire;
use App\Models\Disk;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'product_type_id', 'name', 'short_description',
        'full_description','show_on_homepage','meta_keywords','meta_description',
        'meta_title','sku','manufacturer_part_number','gtin','is_ship_enabled',
        'is_free_shipping','ship_separately','additional_shipping_charge',
        'delivery_date_id','is_tax_exempt','tax_category_id','is_telecommunication_or_broadcast',
        'manage_inventory_method_id',
        'product_availability_range_id', 'use_multiple_warehouses','warehouse_id', 'stock_quantity',
        'display_stock_availability', 'display_stock_quantity','min_stock_quantity',
        'low_stock_activity_id', 'notify_admin_for_quantity_below','backorder_mode_id',
        'allow_back_in_stock_subscriptions', 'order_minimum_quantity','order_maximum_quantity',
        'allowed_quantities', 'allow_adding_only_existing_attribute_combinations',
        'not_returnable', 'disable_buy_button', 'disable_wish_list_button',
        'available_for_pre_order', 'pre_order_availability_start_date_utc',
        'call_for_price', 'price', 'old_price', 'product_cost',
        'customer_enters_price', 'minimum_customer_entered_price',
        'maximum_customer_entered_price', 'baseprice_enabled', 'baseprice_amount', 'baseprice_unit_id',
        'baseprice_base_amount', 'baseprice_base_unit_id', 'mark_as_new',
        'mark_as_new_start_date_time_utc', 'mark_as_new_end_date_time_utc', 'has_tier_prices',
        'has_discount_applied', 'weight', 'length', 'width', 'height', 'available_start_date_time_utc',
        'display_order', 'published', 'deleted', 'created_on_utc', 'updated_on_utc',
        'code', 'parse_id', 'moment', 'publish_in_kaspi', 'publish_in_main',
        'market_place_quantity','last_kaspi_price', 'indeks_nagruzki', 'vidy_nomenklaturi',
        'diametr_shin', 'indeks_skorosti', 'brendy', 'sezony', 'razmer_shiny', 'shirina_shin',
        'modeli', 'vysota_shin', 'shipy', 'usileniye','run_flat', 'nepublikovat','otverstiya', 'rasstoyaniya',
        'kolichestvo_boltov', 'cveta', 'image'
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function manufacturers(): BelongsToMany
    {
        return $this->belongsToMany(Manufacturer::class, 'product_manufacturer_mapping', 'products_id','manufacturer_id')
            ->withPivot('is_featured_product', 'display_order');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category_mappings', 'products_id', 'category_id')
            ->withPivot('is_featured_product', 'display_order');
    }
    public function tires()
    {
        return $this->hasMany(Tire::class, 'product_id');
    }

    public function disks()
    {
        return $this->hasMany(Disk::class, 'product_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
//    protected static function boot()
//    {
//        parent::boot();
//
//        static::saving(function ($product) {
//            $product->slug = $product->generateSlug($product->name);
//        });
//    }
}
