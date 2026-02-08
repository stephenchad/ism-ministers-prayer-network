<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Add multilingual columns to page_contents table for:
     * - Spanish (es)
     * - French (fr)
     * - Portuguese (pt)
     * - Arabic (ar)
     */
    public function up(): void
    {
        Schema::table('page_contents', function (Blueprint $table) {
            // Spanish translations
            $table->string('title_es', 255)->nullable()->after('title');
            $table->string('subtitle_es', 255)->nullable()->after('subtitle');
            $table->text('content_es')->nullable()->after('content');

            // French translations
            $table->string('title_fr', 255)->nullable()->after('title_es');
            $table->string('subtitle_fr', 255)->nullable()->after('subtitle_es');
            $table->text('content_fr')->nullable()->after('content_es');

            // Portuguese translations
            $table->string('title_pt', 255)->nullable()->after('title_fr');
            $table->string('subtitle_pt', 255)->nullable()->after('subtitle_fr');
            $table->text('content_pt')->nullable()->after('content_fr');

            // Arabic translations
            $table->string('title_ar', 255)->nullable()->after('title_pt');
            $table->string('subtitle_ar', 255)->nullable()->after('subtitle_pt');
            $table->text('content_ar')->nullable()->after('content_pt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_contents', function (Blueprint $table) {
            // Drop Arabic columns
            $table->dropColumn('title_ar');
            $table->dropColumn('subtitle_ar');
            $table->dropColumn('content_ar');

            // Drop Portuguese columns
            $table->dropColumn('title_pt');
            $table->dropColumn('subtitle_pt');
            $table->dropColumn('content_pt');

            // Drop French columns
            $table->dropColumn('title_fr');
            $table->dropColumn('subtitle_fr');
            $table->dropColumn('content_fr');

            // Drop Spanish columns
            $table->dropColumn('title_es');
            $table->dropColumn('subtitle_es');
            $table->dropColumn('content_es');
        });
    }
};
