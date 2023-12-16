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

            $table->foreignId('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands')->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreignId('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('primary_image');
            $table->string('price');
            $table->string('quantity');
            $table->text('description');
            $table->string('delivery_amount');

            $table->nullableTimestamps();
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
