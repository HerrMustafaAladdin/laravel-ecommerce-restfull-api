<?php

namespace Database\Factories;

use App\Models\API\V1\Order;
use App\Models\API\V1\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'        =>     User::query()->pluck('id')->random()->first(),
            'order_id'       =>     Order::query()->pluck('id')->random()->first(),
            'amount'         =>     $this->faker->numberBetween(100,1000),
            'token'          =>     $this->faker->shuffleString,
            'trans_id'       =>     $this->faker->shuffle('ksjdksjdkj'),
            'status'         =>     $this->faker->numberBetween(0,3),
            'request_from'   =>     "web",
        ];
    }
}
