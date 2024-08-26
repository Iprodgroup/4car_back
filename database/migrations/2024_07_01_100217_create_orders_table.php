<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('number');
            $table->string('city');
            $table->string('district');
            $table->enum('delively_method',['delivery', 'pickup']);
            $table->string('town');
            $table->string('adres');
            $table->string('orient');
            $table->string('work_adres');
            $table->string('phone');
            $table->text('comment')->nullable();
            $table->string('coupon')->nullable();
            $table->enum('payment_method',['cash', 'card']);
            $table->unsignedBigInteger('sum');
            $table->foreignId('status_id')->default(1)->constrained();
            $table->json('tires');
            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
