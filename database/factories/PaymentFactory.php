<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createDate =new Carbon($this->faker->date());
        return [
            'payment_date_open' => new Carbon( $this->faker->date()) ,
            'payment_date_paid' => random_int(1, 100) > 30? new Carbon($this->faker->date()): null,
            'total_amount' =>random_int(1000, 9000),
        ];
    }
}
