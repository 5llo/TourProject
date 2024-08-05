<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' =>$this->faker->company,
            'offer_id' =>$this->faker->numberBetween(1, 3),
            'type' => $this->faker->randomElement(['vehicle', 'hotel', 'chalet', 'restaurant']),
            'location' => [
                'latitude' => $this->faker->latitude,
                'longitude' => $this->faker->longitude,
            ],
        ];
    }
}
