<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // how_we_serve, call_to_action, etc.
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('background_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('page')->default('home');
            $table->string('section_type')->default('default'); // default, cards, features, etc.
            $table->json('meta_data')->nullable(); // Additional data like card items
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};
