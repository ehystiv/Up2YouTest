<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence,
            'description' => fake()->optional()->paragraph,
            'scheduled_at' => fake()->dateTime,
            'location' => fake()->address,
            'max_attendees' => fake()->numberBetween(20, 100),
        ];
    }
}
