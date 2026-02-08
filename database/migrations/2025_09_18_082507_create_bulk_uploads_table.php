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
        Schema::create('bulk_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('model_type');
            $table->string('status')->default('pending'); // pending, processing, completed, failed
            $table->unsignedBigInteger('uploaded_by');
            $table->text('error_log')->nullable();
            $table->timestamps();

            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulk_uploads');
    }
};
