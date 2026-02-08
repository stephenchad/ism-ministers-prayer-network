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
        Schema::create('prayer_resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('file_path')->nullable();
            $table->string('file_size')->nullable();
            $table->string('file_type')->nullable();
            $table->string('video_url')->nullable();
            $table->string('video_file')->nullable();
            $table->string('duration')->nullable();
            $table->enum('resource_type', ['file', 'video'])->default('file');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prayer_resources');
    }
};
