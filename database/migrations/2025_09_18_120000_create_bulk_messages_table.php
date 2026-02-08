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
        Schema::create('bulk_messages', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'email' or 'sms'
            $table->string('subject')->nullable(); // For emails
            $table->text('message');
            $table->json('recipients'); // Store recipient IDs or emails/phones
            $table->integer('total_recipients')->default(0);
            $table->integer('sent_count')->default(0);
            $table->integer('failed_count')->default(0);
            $table->json('failed_recipients')->nullable(); // Store failed recipient details
            $table->timestamp('sent_at')->nullable();
            $table->unsignedBigInteger('sent_by'); // Admin user ID
            $table->foreign('sent_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulk_messages');
    }
};
