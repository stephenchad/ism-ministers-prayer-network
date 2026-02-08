<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, modify the resource_type enum to include 'guide'
        DB::statement("ALTER TABLE prayer_resources MODIFY COLUMN resource_type ENUM('file', 'video', 'guide') DEFAULT 'file'");
        
        // Then add the missing columns
        Schema::table('prayer_resources', function (Blueprint $table) {
            $table->text('guide_content')->nullable()->after('resource_type');
            $table->string('reading_time')->nullable()->after('guide_content');
            $table->string('icon')->nullable()->after('reading_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the added columns
        Schema::table('prayer_resources', function (Blueprint $table) {
            $table->dropColumn(['guide_content', 'reading_time', 'icon']);
        });
        
        // Revert the enum back to original values
        DB::statement("ALTER TABLE prayer_resources MODIFY COLUMN resource_type ENUM('file', 'video') DEFAULT 'file'");
    }
};