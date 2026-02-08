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
        Schema::table('news', function (Blueprint $table) {
            $table->string('title')->after('id');
            $table->string('slug')->unique()->after('title');
            $table->text('excerpt')->after('slug');
            $table->longText('content')->after('excerpt');
            $table->string('image')->nullable()->after('content');
            $table->enum('type', ['news', 'event'])->after('image');
            $table->datetime('event_date')->nullable()->after('type');
            $table->string('event_location')->nullable()->after('event_date');
            $table->boolean('is_featured')->default(false)->after('event_location');
            $table->boolean('status')->default(true)->after('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['title', 'slug', 'excerpt', 'content', 'image', 'type', 'event_date', 'event_location', 'is_featured', 'status']);
        });
    }
};
