<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
      public function run()
      {
            User::create([
                  'name' => 'Test User',
                  'email' => 'test2@example.com',
                  'password' => Hash::make('password'),
                  // Add other required fields if necessary, e.g., 'leader_level' => 0, etc.
            ]);
      }
}
