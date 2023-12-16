<?php

namespace Database\Factories;


use App\Models\API\V1\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'parent_id'     =>  Category::query()->where('id', '<>', $this->id)->pluck('id')->random()->first(),
            'name'          =>  $this->faker->name,
            'description'   =>  $this->faker->text
        ];
    }
}
