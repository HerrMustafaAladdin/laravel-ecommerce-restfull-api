<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand_id'            =>    Brand::query()->pluck('id')->first(),
            'category_id'         =>    Category::query()->pluck('id')->first(),
            'primary_image'       =>    $this->faker->image,
            'price'               =>    $this->faker->numberBetween(100, 1000),
            'quantity'            =>    $this->faker->numberBetween(1,10),
            'description'         =>    $this->faker->text,
            'delivery_amount'     =>    $this->faker->numberBetween(0,230),
        ];
    }
}
