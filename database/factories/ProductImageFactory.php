<?php

namespace Database\Factories;

use App\Models\API\V1\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id'    =>  Product::query()->pluck('id')->random()->first(),
            'image'         =>  $this->faker->image,
        ];
    }
}
