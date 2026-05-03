<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nopol' => $this->faker->regexify('[A-Z]{1,2} \d{1,4} [A-Z]{1,3}'),
            'type' => $this->faker->word(),
            'category' => $this->faker->randomElement(['Mobil', 'Truk', 'Bus', 'Sepeda Motor']),
            'year' => $this->faker->year(),
            'unit_number' => 'UNIT-' . str_pad($this->faker->unique()->randomDigitNotNull(), 3, '0', STR_PAD_LEFT),
        ];
    }
}
