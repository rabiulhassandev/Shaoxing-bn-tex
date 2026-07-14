<?php

namespace Database\Factories;

use App\Models\Stat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Stat>
 */
class StatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label' => Str::title(fake()->words(3, true)),
            'value' => (string) fake()->numberBetween(10, 500),
            'suffix' => '+',
            'sort_order' => 0,
        ];
    }
}
