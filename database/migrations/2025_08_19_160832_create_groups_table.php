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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->text('description')->nullable();
            $table->unsignedInteger('max_members')->default(0);
            $table->unsignedInteger('current_members')->default(0);
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
