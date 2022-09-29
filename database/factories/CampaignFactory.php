<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->text(20),
            'status' => $this->faker->randomElement(['Preparing', 'Ready', 'Dispatched']),
            'dispatch_date' => $this->faker->dateTimeBetween('+2 week', '+4 week'),
            'delivery_date' => $this->faker->dateTimeBetween('+2 week', '+4 week'),

        ];
    }
}
