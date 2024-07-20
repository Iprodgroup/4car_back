<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('product_manufacturer_mapping_models', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('products_id');
            $table->unsignedBigInteger('manufacturer_id');
            $table->integer('is_featured_product')->default(0);
            $table->integer('display_order')->nullable();
            $table->foreign('products_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_manufacturer_mapping_models');
    }
};
