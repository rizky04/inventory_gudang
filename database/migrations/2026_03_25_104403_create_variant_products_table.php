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
        Schema::create('variant_products', function (Blueprint $table) {
           $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('number_sku');
            $table->string('name_variant');
            $table->string('image_variant');
            $table->integer('price_variant');
            $table->integer('stok_variant');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_products');
    }
};
