<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_flash_sale', 'flash_sale_pdf', 'flash_sale_excel']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_flash_sale')->default(false);
            $table->string('flash_sale_pdf')->nullable();
            $table->string('flash_sale_excel')->nullable();
        });
    }
};
