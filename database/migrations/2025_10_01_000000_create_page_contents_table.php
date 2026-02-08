<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('page', 100);
            $table->string('section', 100)->nullable();
            $table->string('key', 100);
            $table->string('title', 255)->nullable();
            $table->string('subtitle', 255)->nullable();
            $table->text('content')->nullable();
            $table->string('image', 255)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['page', 'key'], 'page_key_unique');
            $table->index(['page', 'section']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_contents');
    }
};
