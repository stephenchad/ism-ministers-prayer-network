<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'title' => 'Healing School',
                'slug' => 'healing-school',
                'description' => 'Experience divine healing through faith-based teachings and prayer sessions focused on physical, emotional, and spiritual restoration.',
                'details' => 'Our Healing School is a comprehensive program designed to help individuals experience God\'s healing power in every area of their lives.',
                'schedule' => 'Every Sunday at 3:00 PM',
                'location' => 'Main Sanctuary',
                'icon' => 'fas fa-heart',
                'color' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                'status' => 1
            ],
            [
                'title' => 'Prayer Academy',
                'slug' => 'prayer-academy',
                'description' => 'Deepen your prayer life through comprehensive training programs designed to enhance your spiritual growth and intercession skills.',
                'details' => 'The Prayer Academy offers structured courses on various aspects of prayer including intercession, spiritual warfare, and developing intimacy with God.',
                'schedule' => 'Wednesdays at 7:00 PM',
                'location' => 'Prayer Room A',
                'icon' => 'fas fa-graduation-cap',
                'color' => 'linear-gradient(135deg, #28a745 0%, #20c997 100%)',
                'status' => 1
            ],
            [
                'title' => 'Youth Ministry',
                'slug' => 'youth-ministry',
                'description' => 'Empowering the next generation through dynamic youth programs, mentorship, and spiritual development activities.',
                'details' => 'Our Youth Ministry focuses on building strong Christian foundations in young people through engaging activities and mentorship programs.',
                'schedule' => 'Saturdays at 4:00 PM',
                'location' => 'Youth Center',
                'icon' => 'fas fa-users',
                'color' => 'linear-gradient(135deg, #fd7e14 0%, #ffc107 100%)',
                'status' => 1
            ]
        ];

        foreach ($programs as $program) {
            \App\Models\Program::create($program);
        }
    }
}
