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
        Schema::table('groups', function (Blueprint $table) {
            // Drop the old string columns
            $table->dropColumn(['country', 'city']);
            
            // Add foreign key columns
            $table->foreignId('country_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            // Drop foreign key columns
            $table->dropForeign(['country_id']);
            $table->dropForeign(['city_id']);
            $table->dropColumn(['country_id', 'city_id']);
            
            // Add back the string columns
            $table->string('country');
            $table->string('city');
        });
    }
};