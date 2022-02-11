<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = implode(' ', $this->faker->unique()->words(2));

        return [
            'name' => Str::title($name),
            'code' => Str::snake($name),
            'description' => $this->faker->sentence(),
        ];
    }
}
