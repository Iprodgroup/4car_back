<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tires', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('code');
            $table->string('description');
            $table->boolean('is_replica');
            $table->string('shirina');
            $table->string('visota');
            $table->string('diametr');
            $table->unsignedBigInteger('item');
            $table->string('ext_code');
            $table->timestamps();
            $table->foreign('item')->references('id')->on('cars')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('tires');
    }
};
