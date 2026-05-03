<?php

namespace Database\Factories;

use App\Models\Part;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockMovement>
 */
class StockMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'part_id' => Part::factory(),
            'type' => $this->faker->randomElement(['in', 'out']),
            'quantity' => $this->faker->numberBetween(1, 100),
            'reference_id' => null,
            'reference_type' => null,
            'note' => $this->faker->sentence(),
            'user_id' => User::factory(),
        ];
    }
}
