<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('excess_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('particulars');
            $table->string('excel_file')->nullable();
            $table->string('pdf_file')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('excess_inventories');
    }
};
