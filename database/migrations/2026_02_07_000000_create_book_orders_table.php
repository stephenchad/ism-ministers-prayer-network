<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This table stores minimal references to orders from Department B
     * for quick lookup and caching. All authoritative data remains in Dept B.
     */
    public function up(): void
    {
        Schema::create('book_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_id')->unique(); // Department B order ID
            $table->string('book_id'); // Department B book ID
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->decimal('amount', 10, 2)->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_orders');
    }
};
