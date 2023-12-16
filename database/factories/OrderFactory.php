<?php

namespace Database\Factories;

use App\Models\API\V1\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'           =>      User::query()->pluck('id')->random()->first(),
            'status'            =>      $this->faker->numberBetween(0,3),
            'total_amount'      =>      $this->faker->numberBetween(10000, 20000),
            'paying_amount'     =>      $this->faker->numberBetween(1000, 20000),
            'delivery_amount'   =>      $this->faker->numberBetween(100, 300),
            'payment_status'    =>      $this->faker->numberBetween(0,1),
            'description'       =>      $this->faker->text,
        ];
    }
}
