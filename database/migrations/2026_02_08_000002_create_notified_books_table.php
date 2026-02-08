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
        Schema::create('notified_books', function (Blueprint $table) {
            $table->string('book_id')->primary();
            $table->string('title')->nullable();
            $table->string('author')->nullable();
            $table->timestamp('notified_at')->useCurrent();
            $table->boolean('email_sent')->default(false);
            $table->boolean('notification_sent')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notified_books');
    }
};
