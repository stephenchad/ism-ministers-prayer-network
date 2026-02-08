<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PrayerPoint;

class PrayerPointSeeder extends Seeder
{
      public function run()
      {
            $prayerPoints = [
                  [
                        'title' => 'Prayer for Healing',
                        'content' => 'Father, we pray for healing in our bodies, minds, and spirits. Touch every area of sickness and bring Your divine restoration.',
                        'status' => 'approved',
                        'user_id' => 1, // Assuming admin user ID
                  ],
                  [
                        'title' => 'Prayer for Wisdom in Leadership',
                        'content' => 'Lord, grant our leaders wisdom and understanding to make decisions that honor You and benefit Your people.',
                        'status' => 'approved',
                        'user_id' => 1,
                  ],
                  [
                        'title' => 'Prayer for Unity in the Church',
                        'content' => 'Heavenly Father, bring unity among believers. Let us stand together in love and purpose for Your kingdom.',
                        'status' => 'approved',
                        'user_id' => 1,
                  ],
            ];

            foreach ($prayerPoints as $point) {
                  PrayerPoint::create($point);
            }
      }
}
