<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'image' => "null.jpg",
            'name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(10000, 100000),
            'description' => $this->faker->sentence(7),
            'category' => $this->faker->randomElement(['Makanan', 'Minuman', 'Camilan']),
            'stock' => $this->faker->numberBetween(1, 10),
        ];
    }
}
