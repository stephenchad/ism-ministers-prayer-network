<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('worship_music', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('artist');
            $table->text('description')->nullable();
            $table->enum('music_type', ['streaming', 'download']);
            $table->string('file_path');
            $table->string('file_size')->nullable();
            $table->string('duration')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worship_music');
    }
};