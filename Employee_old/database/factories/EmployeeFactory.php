<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'salary' => $this->faker->numberBetween(1000, 100000),
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at'  => date('Y-m-d h:m:s')
        ];
    }
}
