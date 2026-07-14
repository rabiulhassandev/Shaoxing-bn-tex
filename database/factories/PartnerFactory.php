<?php

namespace Database\Factories;

use App\Enums\PartnerType;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Partner>
 */
class PartnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(PartnerType::cases()),
            'name' => fake()->unique()->company(),
            'logo' => null,
            'website' => fake()->url(),
            'sort_order' => 0,
            'is_active' => true,
        ];
    }

    public function buyer(): static
    {
        return $this->state(fn (): array => ['type' => PartnerType::Buyer]);
    }

    public function vendor(): static
    {
        return $this->state(fn (): array => ['type' => PartnerType::Vendor]);
    }
}
