<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PrayerRequest;

class PrayerRequestSeeder extends Seeder
{
      public function run(): void
      {
            $requests = [
                  [
                        'name' => 'John Doe',
                        'email' => 'john@example.com',
                        'prayer_type' => 'healing',
                        'prayer_request' => 'Please pray for my recovery from illness.'
                  ],
                  [
                        'name' => 'Jane Smith',
                        'email' => 'jane@example.com',
                        'prayer_type' => 'family',
                        'prayer_request' => 'Pray for unity in my family.'
                  ],
                  [
                        'name' => null,
                        'email' => null,
                        'prayer_type' => 'financial',
                        'prayer_request' => 'Need prayers for financial stability.'
                  ],
                  [
                        'name' => 'Bob Johnson',
                        'email' => 'bob@example.com',
                        'prayer_type' => 'spiritual',
                        'prayer_request' => 'Seeking spiritual growth and wisdom.'
                  ],
                  [
                        'name' => 'Alice Brown',
                        'email' => null,
                        'prayer_type' => 'guidance',
                        'prayer_request' => 'Please pray for guidance in my career decisions.'
                  ],
                  [
                        'name' => null,
                        'email' => 'anon@example.com',
                        'prayer_type' => 'other',
                        'prayer_request' => 'General prayers for peace and well-being.'
                  ]
            ];

            foreach ($requests as $request) {
                  PrayerRequest::create($request);
            }
      }
}
