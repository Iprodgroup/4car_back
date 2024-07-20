<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('product_type_id');
            $table->text('name');
            $table->text('short_description')->nullable();
            $table->text('full_description')->nullable();
            $table->tinyInteger('show_on_homepage')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('sku')->nullable();
            $table->text('manufacturer_part_number')->nullable();
            $table->text('gtin')->nullable();
            $table->tinyInteger('is_ship_enabled')->nullable();
            $table->tinyInteger('is_free_shipping')->nullable();
            $table->tinyInteger('ship_separately')->nullable();
            $table->decimal('additional_shipping_charge', 18, 4)->nullable();
            $table->integer('delivery_date_id')->nullable();
            $table->tinyInteger('is_tax_exempt')->nullable();
            $table->integer('tax_category_id')->nullable();
            $table->tinyInteger('is_telecommunication_or_broadcast')->nullable();
            $table->integer('manage_inventory_method_id')->nullable();
            $table->integer('product_availability_range_id')->nullable();
            $table->integer('use_multiple_warehouses')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->integer('stock_quantity')->nullable();
            $table->integer('display_stock_availability')->nullable();
            $table->integer('display_stock_quantity')->nullable();
            $table->integer('min_stock_quantity')->nullable();
            $table->integer('low_stock_activity_id')->nullable();
            $table->integer('notify_admin_for_quantity_below')->nullable();
            $table->integer('backorder_mode_id')->nullable();
            $table->integer('allow_back_in_stock_subscriptions')->nullable();
            $table->integer('order_minimum_quantity')->nullable();
            $table->integer('order_maximum_quantity')->nullable();
            $table->text('allowed_quantities')->nullable();
            $table->integer('allow_adding_only_existing_attribute_combinations')->nullable();
            $table->integer('not_returnable')->nullable();
            $table->integer('disable_buy_button')->nullable();
            $table->integer('disable_wish_list_button')->nullable();
            $table->integer('available_for_pre_order')->nullable();
            $table->dateTime('pre_order_availability_start_date_utc')->nullable();
            $table->integer('call_for_price')->nullable();
            $table->decimal('price', 18, 4)->nullable();
            $table->decimal('old_price', 18, 4)->nullable();
            $table->decimal('product_cost', 18, 4)->nullable();
            $table->tinyInteger('customer_enters_price')->nullable();
            $table->tinyInteger('minimum_customer_entered_price')->nullable();
            $table->tinyInteger('maximum_customer_entered_price')->nullable();
            $table->tinyInteger('baseprice_enabled')->nullable();
            $table->decimal('baseprice_amount', 18, 4)->nullable();
            $table->integer('baseprice_unit_id')->nullable();
            $table->integer('baseprice_base_amount')->nullable();
            $table->integer('baseprice_base_unit_id')->nullable();
            $table->integer('mark_as_new')->nullable();
            $table->dateTime('mark_as_new_start_date_time_utc')->nullable();
            $table->dateTime('mark_as_new_end_date_time_utc')->nullable();
            $table->tinyInteger('has_tier_prices')->nullable();
            $table->tinyInteger('has_discount_applied')->nullable();
            $table->decimal('weight', 18, 4);
            $table->decimal('length', 18, 4);
            $table->decimal('width', 18, 4);
            $table->decimal('height', 18, 4);
            $table->dateTime('available_start_date_time_utc')->nullable();
            $table->integer('display_order')->nullable();
            $table->tinyInteger('published')->nullable();
            $table->tinyInteger('deleted')->nullable();
            $table->dateTime('created_on_utc')->nullable();
            $table->dateTime('updated_on_utc')->nullable();
            $table->integer('code')->nullable();
            $table->bigInteger('parse_id')->nullable();
            $table->bigInteger('moment')->nullable();
            $table->tinyInteger('publish_in_kaspi')->nullable();
            $table->tinyInteger('publish_in_main')->nullable();
            $table->tinyInteger('market_place_quantity')->nullable();
            $table->integer('last_kaspi_price')->nullable();
            $table->timestamps();
            $table->string('indeks_nagruzki')->nullable();
            $table->string('vidy_nomenklaturi')->nullable();
            $table->string('diametr_shin')->nullable();
            $table->string('indeks_skorosti')->nullable();
            $table->string('brendy')->nullable();
            $table->string('sezony')->nullable();
            $table->string('razmer_shiny')->nullable();
            $table->string('shirina_shin')->nullable();
            $table->string('modeli')->nullable();
            $table->string('vysota_shin')->nullable();
            $table->string('shipy')->nullable();
            $table->string('usileniye')->nullable();
            $table->string('run_flat')->nullable();
            $table->string('nepublikovat')->nullable();
            $table->string('otverstiya')->nullable();
            $table->string('rasstoyaniya')->nullable();
            $table->string('kolichestvo_boltov')->nullable();
            $table->string('cveta')->nullable();
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
