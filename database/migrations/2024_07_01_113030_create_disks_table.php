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
            $table->string('model');
            $table->string('weight');
            $table->string('height');
            $table->string('diametr');
            $table->string('season');
            $table->string('spikes');
            $table->string('index_n');
            $table->string('index_s');
            $table->string('run_flat');
            $table->string('image');
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
