<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        News::create([
            'title' => 'Annual Prayer Conference 2024',
            'slug' => 'annual-prayer-conference-2024',
            'excerpt' => 'Join us for our biggest prayer gathering of the year with renowned speakers and powerful worship.',
            'content' => 'We are excited to announce our Annual Prayer Conference 2024, a three-day event that will transform your prayer life. This year\'s theme is "Breakthrough in Prayer" and we have invited some of the most anointed prayer warriors to minister to us.',
            'type' => 'event',
            'event_date' => '2024-12-15 09:00:00',
            'event_location' => 'ISM Ministers Prayer Center',
            'is_featured' => true,
            'status' => true
        ]);

        News::create([
            'title' => 'New Prayer Group Leaders Ordained',
            'slug' => 'new-prayer-group-leaders-ordained',
            'excerpt' => 'We celebrate the ordination of 15 new prayer group leaders who will serve in various regions.',
            'content' => 'In a beautiful ceremony last Sunday, we ordained 15 dedicated members as new prayer group leaders. These faithful servants have completed our intensive leadership training program and are ready to guide prayer groups in their respective regions.',
            'type' => 'news',
            'is_featured' => false,
            'status' => true
        ]);

        News::create([
            'title' => 'Monthly Fasting and Prayer',
            'slug' => 'monthly-fasting-and-prayer',
            'excerpt' => 'Join our monthly corporate fasting and prayer for breakthrough in our nation and personal lives.',
            'content' => 'Every first Friday of the month, we come together for corporate fasting and prayer. This is a time of seeking God\'s face for breakthrough in our personal lives, families, and nation.',
            'type' => 'event',
            'event_date' => '2024-10-04 06:00:00',
            'event_location' => 'All Prayer Centers',
            'is_featured' => true,
            'status' => true
        ]);

        News::create([
            'title' => 'Testimony: Miraculous Healing Through Prayer',
            'slug' => 'testimony-miraculous-healing-through-prayer',
            'excerpt' => 'Sister Mary shares her powerful testimony of divine healing after months of prayer and faith.',
            'content' => 'Sister Mary Johnson was diagnosed with a terminal illness six months ago. Through the power of prayer and unwavering faith, she has received complete healing. Her testimony reminds us that nothing is impossible with God.',
            'type' => 'news',
            'is_featured' => false,
            'status' => true
        ]);
    }
}
