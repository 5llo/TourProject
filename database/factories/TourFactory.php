<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'designer_id' => $this->faker->numberBetween(1, 3),
            'path' => [
                ['latitude' => $this->faker->latitude, 'longitude' => $this->faker->longitude],
                ['latitude' => $this->faker->latitude, 'longitude' => $this->faker->longitude],
                ['latitude' => $this->faker->latitude, 'longitude' => $this->faker->longitude],

            ],
            'quantity' => $this->faker->numberBetween(20, 40),
            'date_start' => $this->faker->dateTimeBetween('+1 week', '+2 months'),
            'date_end' => $this->faker->dateTimeBetween('+3 months', '+6 months'),
            'description' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['active', 'terminated', 'pending', 'rejected']),
            'price' => $this->faker->randomFloat(2, 100, 1000)
        ];
    }
}
