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
            // Link style
            $table->string('link_style')->default('primary')->after('link_text');

            // Layout fields
            $table->string('layout_style')->default('default')->after('link_style');
            $table->string('column_count')->default('1')->after('layout_style');
            $table->string('content_width')->default('default')->after('column_count');
            $table->string('bg_type')->default('none')->after('content_width');
            $table->string('bg_color')->nullable()->after('bg_type');
            $table->string('bg_image')->nullable()->after('bg_color');
            $table->string('bg_gradient')->nullable()->after('bg_image');
            $table->string('padding_top')->default('default')->after('bg_gradient');
            $table->string('padding_bottom')->default('default')->after('padding_top');
            $table->string('text_align')->default('default')->after('padding_bottom');
            $table->string('css_class')->nullable()->after('text_align');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_contents', function (Blueprint $table) {
            $table->dropColumn([
                'link_style',
                'layout_style',
                'column_count',
                'content_width',
                'bg_type',
                'bg_color',
                'bg_image',
                'bg_gradient',
                'padding_top',
                'padding_bottom',
                'text_align',
                'css_class',
            ]);
        });
    }
};
