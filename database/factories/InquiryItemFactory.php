<?php

namespace Database\Factories;

use App\Models\Fabric;
use App\Models\Inquiry;
use App\Models\InquiryItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<InquiryItem>
 */
class InquiryItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'inquiry_id' => Inquiry::factory(),
            'fabric_id' => Fabric::factory(),
            'fabric_name' => Str::title(fake()->words(3, true)),
            'quantity' => fake()->randomElement(['3,000 m', '5,000 yards', '10,000 m']),
            'target_price' => fake()->randomElement(['$1.85/m', '$2.10/yd', 'Open to offer']),
            'note' => fake()->sentence(),
        ];
    }
}
