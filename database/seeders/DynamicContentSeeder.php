<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSlider;
use App\Models\SiteStat;
use App\Models\PageSection;

class DynamicContentSeeder extends Seeder
{
    public function run(): void
    {
        // Create homepage sliders
        $sliders = [
            [
                'title' => 'United in Prayer',
                'subtitle' => 'Join a global community of ministers in prayer',
                'button_text' => 'Join Now',
                'button_url' => route('account.registration'),
                'desktop_image' => 'assets/images/slider/30-DAYS-PRAYER-FEST-WEBSITE-BANNER.jpeg',
                'mobile_image' => 'assets/images/slider/11.jpg',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Grow in Prayer',
                'subtitle' => 'Deepen your prayer life with rich studies and guides',
                'button_text' => 'Explore Resources',
                'button_url' => route('prayer.resources'),
                'desktop_image' => 'assets/images/slider/Prayer_Studies_webpage.jpg',
                'mobile_image' => 'assets/images/slider/11.jpg',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Intercession',
                'subtitle' => 'Stand in the gap for nations and the Church',
                'button_text' => 'Submit a Request',
                'button_url' => route('prayers'),
                'desktop_image' => 'assets/images/slider/Standing_in_the_Gap_Web.jpg',
                'mobile_image' => 'assets/images/slider/11.jpg',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Connect and Pray',
                'subtitle' => 'Join prayer groups worldwide',
                'button_text' => 'Find Groups',
                'button_url' => route('groups.index'),
                'desktop_image' => 'assets/images/slider/ministers_prayer_network.jpg',
                'mobile_image' => 'assets/images/slider/11.jpg',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($sliders as $slider) {
            PageSlider::updateOrCreate(
                ['title' => $slider['title'], 'page' => 'home'],
                $slider
            );
        }

        // Create site stats for home page - using unique keys
        $homeStats = [
            [
                'key' => 'home_hours_of_prayer',
                'label' => 'Hours of Prayer',
                'value' => '24/7',
                'icon' => 'fa-clock',
                'description' => 'Continuous intercession around the world',
                'page' => 'home',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'key' => 'home_prayer_requests',
                'label' => 'Prayer Requests',
                'value' => '10K+',
                'icon' => 'fa-praying-hands',
                'description' => 'Answered and counting',
                'page' => 'home',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'key' => 'home_prayer_groups',
                'label' => 'Prayer Groups',
                'value' => '500+',
                'icon' => 'fa-users',
                'description' => 'Active communities worldwide',
                'page' => 'home',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'key' => 'home_days_year',
                'label' => 'Days a Year',
                'value' => '365',
                'icon' => 'fa-calendar',
                'description' => 'Never-ending commitment to prayer',
                'page' => 'home',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($homeStats as $stat) {
            SiteStat::updateOrCreate(
                ['key' => $stat['key']],
                $stat
            );
        }

        // Create site stats for about page - using unique keys
        $aboutStats = [
            [
                'key' => 'about_prayer_partners',
                'label' => 'Prayer Partners',
                'value' => '50K+',
                'icon' => 'fa-users',
                'description' => 'Ministers worldwide standing in faith',
                'page' => 'about',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'key' => 'about_hours_prayer',
                'label' => '24/7 Prayer',
                'value' => '24/7',
                'icon' => 'fa-clock',
                'description' => 'Never-ending intercession',
                'page' => 'about',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'key' => 'about_countries',
                'label' => 'Countries',
                'value' => '150+',
                'icon' => 'fa-globe',
                'description' => 'Reaching nations globally',
                'page' => 'about',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'key' => 'about_days_year',
                'label' => 'Days a Year',
                'value' => '365',
                'icon' => 'fa-calendar',
                'description' => 'Continuous service to the body of Christ',
                'page' => 'about',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($aboutStats as $stat) {
            SiteStat::updateOrCreate(
                ['key' => $stat['key']],
                $stat
            );
        }

        // Create page sections
        $sections = [
            [
                'key' => 'how_we_serve',
                'title' => 'How We Serve',
                'subtitle' => 'Tools and ministries to help you pray and grow',
                'page' => 'home',
                'section_type' => 'features',
                'meta_data' => json_encode([
                    [
                        'icon' => 'fa-praying-hands',
                        'title' => 'Prayer Requests',
                        'description' => 'Share your requests and let ministers stand in faith with you.',
                        'url' => route('prayers'),
                        'button_text' => 'Submit a Request →',
                    ],
                    [
                        'icon' => 'fa-users',
                        'title' => 'Prayer Groups',
                        'description' => 'Connect with local or online groups to pray together.',
                        'url' => route('groups.index'),
                        'button_text' => 'Join Groups →',
                    ],
                    [
                        'icon' => 'fa-heart',
                        'title' => 'Testimonies',
                        'description' => 'Read inspiring stories of answered prayers.',
                        'url' => route('testimonies'),
                        'button_text' => 'Read Stories →',
                    ],
                    [
                        'icon' => 'fa-book-open',
                        'title' => 'Prayer Points',
                        'description' => 'Follow powerful, Spirit-led prayer points daily.',
                        'url' => route('prayer-points.index'),
                        'button_text' => 'Read Points →',
                    ],
                ]),
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'key' => 'call_to_action',
                'title' => 'Take the Next Step',
                'subtitle' => 'Join us in prayer and connect with fellow ministers',
                'page' => 'home',
                'section_type' => 'cta',
                'meta_data' => json_encode([
                    [
                        'icon' => 'fa-praying-hands',
                        'title' => 'Submit a Prayer Request',
                        'url' => route('prayers'),
                    ],
                    [
                        'icon' => 'fa-users',
                        'title' => 'Join Prayer Groups',
                        'url' => route('groups.index'),
                    ],
                ]),
                'sort_order' => 10,
                'is_active' => true,
            ],
        ];

        foreach ($sections as $section) {
            PageSection::updateOrCreate(
                ['key' => $section['key']],
                $section
            );
        }
    }
}
