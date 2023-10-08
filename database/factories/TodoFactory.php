<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'body' => fake()->sentence(5),
            'checked' => rand(0, 1)
        ];
    }
}
