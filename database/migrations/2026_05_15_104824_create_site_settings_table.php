<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_header_logo')->nullable();
            $table->string('site_footer_logo')->nullable();
            $table->string('site_address')->nullable();
            $table->text('site_description')->nullable();
            $table->string('site_copyright')->nullable();
            $table->text('site_google_map')->nullable();

            // Hidden / legacy fields (kept for backward compat)
            $table->string('site_email')->nullable();
            $table->string('site_email_alt')->nullable();
            $table->string('site_phone')->nullable();
            $table->string('site_phone_alt')->nullable();

            // Person 1
            $table->string('person1_name')->nullable();
            $table->string('person1_email')->nullable();
            $table->string('person1_phone')->nullable();

            // Person 2
            $table->string('person2_name')->nullable();
            $table->string('person2_email')->nullable();
            $table->string('person2_phone')->nullable();

            // Person 3
            $table->string('person3_name')->nullable();
            $table->string('person3_email')->nullable();
            $table->string('person3_phone')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
