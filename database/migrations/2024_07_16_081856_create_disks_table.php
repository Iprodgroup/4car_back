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
            $table->string('status');
            $table->string('code');
            $table->string('description');
            $table->boolean('is_replica');
            $table->string('shirina');
            $table->string('diametr');
            $table->string('vylet1');
            $table->string('vylet2');
            $table->string('boltov');
            $table->string('rasstoyanie');
            $table->unsignedBigInteger('item');
            $table->string('dia');
            $table->string('gayka');
            $table->string('ext_code');
            $table->foreign('item')->references('id')->on('cars')->onDelete('cascade');
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
