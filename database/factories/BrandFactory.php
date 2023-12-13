<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory<\App\Models\Model>
 */
class BrandFactory extends Factory
{

    /**
     * @return array{name: string, display_name: string}
     */
    #[ArrayShape(['name' => "string", 'display_name' => "string"])] public function definition(): array
    {
        return [
            'name'          =>  $this->faker->unique()->name,
            'display_name'  =>  $this->faker->unique()->name
        ];
    }
}
