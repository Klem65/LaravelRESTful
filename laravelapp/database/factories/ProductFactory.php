<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "price" => $this->faker->numberBetween($min = 1500, $max = 6000),
            "published" => $this->faker->boolean(60),
            "deleted" => $this->faker->boolean(20),
        ];
    }
}
