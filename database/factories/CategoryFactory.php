<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Prayer Group',
            'Bible Study',
            'Youth Ministry',
            'Worship Team',
            'Evangelism',
            'Community Service',
            'Men\'s Fellowship',
            'Women\'s Fellowship',
            'Children\'s Ministry',
            'Senior Citizens'
        ];

        return [
            'name' => $this->faker->randomElement($categories),
            'status' => 1
        ];
    }
}
