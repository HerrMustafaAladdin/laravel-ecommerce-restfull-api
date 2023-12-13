<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id'      =>  Order::query()->pluck('id')->random()->first(),
            'product_id'    =>  Product::query()->pluck('id')->random()->first(),
            'price'         =>  $this->faker->numberBetween(1000, 20000),
            'quantity'      =>  $this->faker->numberBetween(1000, 20000),
            'subtotal'      =>  $this->faker->numberBetween(1000, 20000),
        ];
    }
}
