<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cashier_id' => $this->faker->numberBetween(1,2),
            'transaction_date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'income' => $this->faker->numberBetween(100000, 500000),
        ];
    }
}
