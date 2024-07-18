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
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('category_templated_id');
            $table->text('meta_keywords')->nullable();
            $table->longText('meta_description')->nullable();
            $table->text('meta_title')->nullable();
            $table->integer('parent_category_id');
            $table->integer('picture_id');
            $table->integer('page_size');
            $table->tinyInteger('allow_customers_to_select_page_size');
            $table->string('page_resize_options')->nullable();
            $table->text('price_ranges')->nullable();
            $table->tinyInteger('show_on_homepage')->nullable();
            $table->tinyInteger('include_in_top_menu')->nullable();
            $table->tinyInteger('subject_to_acl');
            $table->tinyInteger('limited_to_stories');
            $table->tinyInteger('published');
            $table->tinyInteger('deleted');
            $table->integer('display_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category');
    }
};
