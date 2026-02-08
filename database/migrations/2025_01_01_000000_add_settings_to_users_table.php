<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
      /**
       * Run the migrations.
       */
      public function up(): void
      {
            Schema::table('users', function (Blueprint $table) {
                  $table->boolean('email_prayer')->default(true);
                  $table->boolean('email_newsletter')->default(true);
                  $table->boolean('public_profile')->default(false);
                  $table->boolean('show_email')->default(false);
            });
      }

      /**
       * Reverse the migrations.
       */
      public function down(): void
      {
            Schema::table('users', function (Blueprint $table) {
                  $table->dropColumn(['email_prayer', 'email_newsletter', 'public_profile', 'show_email']);
            });
      }
};
