<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_stats', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // prayer_partners, hours_of_prayer, etc.
            $table->string('label');
            $table->string('value'); // Can be text like "24/7" or number
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->string('page')->default('home'); // home, about, etc.
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_stats');
    }
};
