<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(15),
            'unit_price' => $this->faker->randomNumber(3, false),
            'units_owned' => $this->faker->randomNumber(3, false),
        ];
    }
}
