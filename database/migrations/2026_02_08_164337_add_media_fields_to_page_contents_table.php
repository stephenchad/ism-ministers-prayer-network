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
        Schema::table('page_contents', function (Blueprint $table) {
            // Image fields
            $table->string('image_mobile')->nullable()->after('image');
            
            // Video fields
            $table->string('video_url')->nullable()->after('image_mobile');
            $table->text('video_embed')->nullable()->after('video_url');
            $table->string('video_thumbnail')->nullable()->after('video_embed');
            
            // Link fields
            $table->string('link_text')->nullable()->after('video_thumbnail');
            $table->string('link_url')->nullable()->after('link_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_contents', function (Blueprint $table) {
            $table->dropColumn([
                'image_mobile',
                'video_url',
                'video_embed',
                'video_thumbnail',
                'link_text',
                'link_url',
            ]);
        });
    }
};
