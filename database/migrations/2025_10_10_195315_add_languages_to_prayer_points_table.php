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
        Schema::table('prayer_points', function (Blueprint $table) {
            $table->string('title_es')->nullable();
            $table->string('title_fr')->nullable();
            $table->string('title_zh')->nullable();
            $table->string('title_ar')->nullable();
            $table->text('content_es')->nullable();
            $table->text('content_fr')->nullable();
            $table->text('content_zh')->nullable();
            $table->text('content_ar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prayer_points', function (Blueprint $table) {
            $table->dropColumn(['title_es', 'title_fr', 'title_zh', 'title_ar', 'content_es', 'content_fr', 'content_zh', 'content_ar']);
        });
    }
};
