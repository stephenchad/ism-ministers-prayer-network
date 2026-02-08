<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PrayerType;

class PrayerTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Healing', 'slug' => 'healing', 'icon' => '🙏'],
            ['name' => 'Family', 'slug' => 'family', 'icon' => '👨👩👧👦'],
            ['name' => 'Financial', 'slug' => 'financial', 'icon' => '💰'],
            ['name' => 'Spiritual Growth', 'slug' => 'spiritual', 'icon' => '✨'],
            ['name' => 'Guidance', 'slug' => 'guidance', 'icon' => '🧭'],
            ['name' => 'Other', 'slug' => 'other', 'icon' => '💝'],
        ];

        foreach ($types as $type) {
            PrayerType::updateOrCreate(['slug' => $type['slug']], $type);
        }
    }
}
