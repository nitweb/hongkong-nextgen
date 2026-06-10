<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_battery')->default(false)->after('is_it_product');
            $table->unsignedBigInteger('battery_category_id')->nullable()->after('is_battery');
            $table->string('battery_excel_file')->nullable()->after('battery_category_id');

            $table->foreign('battery_category_id')->references('id')->on('battery_categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['battery_category_id']);
            $table->dropColumn(['is_battery', 'battery_category_id', 'battery_excel_file']);
        });
    }
};
