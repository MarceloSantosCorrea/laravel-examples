<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'body' => fake()->sentence(5),
            'checked' => rand(0, 1),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
