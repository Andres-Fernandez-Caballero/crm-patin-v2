<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'names' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'dni' => $this->faker->unique()->randomNumber(8),
            'email' => $this->faker->unique()->safeEmail,
            //'phone' => $this->faker->phoneNumber,
            'birth_date' => $this->faker->date(),
        ];
    }
}
