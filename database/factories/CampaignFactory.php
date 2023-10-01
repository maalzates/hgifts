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
        // Generate a dispatch date that is in the future
        $dispatchDate = $this->faker->dateTimeBetween('+2 week', '+4 week');

        // Generate a delivery date that is after the dispatch date
        $deliveryDate = $this->faker->dateTimeBetween($dispatchDate, '+4 week');

        return [
            'name' => $this->faker->unique()->text(20),
            'status' => $this->faker->randomElement(['Preparing', 'Ready', 'Dispatched']),
            'dispatch_date' => $dispatchDate,
            'delivery_date' => $deliveryDate,
        ];
    }
}
