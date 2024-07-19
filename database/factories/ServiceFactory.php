<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'unit' => fake()->randomElement(Service::availableUnits()),
            'original_price' => fake()->numberBetween(1_000, 25_000),
            'sale_price' => fake()->numberBetween(1_000, 25_000),
        ];
    }
}
