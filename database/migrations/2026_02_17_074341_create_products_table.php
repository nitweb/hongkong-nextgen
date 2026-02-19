<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_category_id')->constrained('product_categories')->cascadeOnUpdate()->restrictOnDelete();

            $table->foreignId('brand_id')->constrained('product_brands')->cascadeOnUpdate()->restrictOnDelete();

            $table->string('product_name');
            $table->string('product_slug')->unique();

            $table->decimal('product_price', 12, 2);
            $table->decimal('discount_price', 12, 2)->nullable();

            $table->string('product_part_number');
            $table->string('package');
            $table->string('date_code');

            $table->longText('product_description')->nullable();
            $table->string('product_image')->nullable();

            $table->boolean('is_flash_sale')->default(false);
            $table->boolean('is_it_product')->default(false);

            $table->enum('stock_status', ['in_stock', 'out_of_stock'])->default('in_stock');
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();

            $table->index(['product_category_id', 'brand_id']);
            $table->index('product_part_number');
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
