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
        Schema::table('products', function (Blueprint $table) {
            $table->string('product_part_number')->nullable()->after('product_specifications');
            $table->string('brand_name')->nullable()->after('product_part_number');
            $table->string('package')->nullable()->after('brand_name');
            $table->string('date_code')->nullable()->after('package');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
             $table->dropColumn(['product_part_number', 'brand_name', 'package', 'date_code']);
        });
    }
};
