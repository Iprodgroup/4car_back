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
        Schema::create('disks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('size');
            $table->string('brand');
            $table->string('model');
            $table->string('number_of_holes');
            $table->string('size_of_holes');
            $table->string('width');
            $table->string('diametr');
            $table->string('departure');
            $table->string('tco');
            $table->string('price');

            
            $table->string('image');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disks');
    }
};
