<?php

namespace Database\Factories;

use App\Models\HeroSlide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HeroSlide>
 */
class HeroSlideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => rtrim(fake()->sentence(6), '.'),
            'subtitle' => fake()->sentence(10),
            'image' => 'hero/placeholder.svg',
            'button_text' => 'View Fabrics',
            'button_url' => '/fabrics',
            'sort_order' => 0,
            'is_active' => true,
        ];
    }
}
