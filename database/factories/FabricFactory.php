<?php

namespace Database\Factories;

use App\Models\Fabric;
use App\Models\FabricCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Fabric>
 */
class FabricFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = Str::title(fake()->unique()->words(3, true));

        return [
            'category_id' => FabricCategory::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => null,
            'construction' => fake()->randomElement(['40x40 133x72', '32x32 130x70', '21x21 108x58', '16x12 108x56', '10x10 74x44']),
            'composition' => fake()->randomElement(['100% Cotton', '65% Polyester 35% Cotton', '55% Linen 45% Viscose', '97% Cotton 3% Spandex', '100% Polyester']),
            'width' => fake()->randomElement(['57/58"', '58/60"', '63"', '110"']),
            'weight' => fake()->numberBetween(90, 380).' GSM',
            'finish' => fake()->randomElement(['Reactive Dyed', 'Peach Finish', 'Enzyme Washed', 'Mercerized', 'Brushed']),
            'colors' => 'Available per buyer requirement',
            'moq' => fake()->randomElement(['1,000 m', '2,000 m', '3,000 m per colour']),
            'lead_time' => fake()->randomElement(['25-30 days', '30-35 days', '35-45 days']),
            'description' => fake()->paragraph(),
            'is_featured' => false,
            'is_active' => true,
            'sort_order' => 0,
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (): array => ['is_featured' => true]);
    }

    public function inactive(): static
    {
        return $this->state(fn (): array => ['is_active' => false]);
    }
}
