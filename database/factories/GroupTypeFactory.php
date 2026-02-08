<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GroupTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $groupTypes = [
            'Online',
            'Offline',
            'Hybrid',
            'Regional',
            'National',
            'International'
        ];

        return [
            'name' => $this->faker->randomElement($groupTypes),
            'status' => 1
        ];
    }
}
