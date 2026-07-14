<?php

namespace Database\Factories;

use App\Enums\InquiryStatus;
use App\Models\Inquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inquiry>
 */
class InquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'company' => fake()->company(),
            'country' => fake()->country(),
            'phone' => fake()->phoneNumber(),
            'message' => fake()->paragraph(),
            'status' => InquiryStatus::New,
        ];
    }

    public function closed(): static
    {
        return $this->state(fn (): array => ['status' => InquiryStatus::Closed]);
    }
}
