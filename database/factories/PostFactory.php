<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = Str::title(fake()->unique()->sentence(5));

        return [
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title),
            'image' => null,
            'excerpt' => fake()->sentence(15),
            'body' => '<p>'.implode('</p><p>', fake()->paragraphs(4)).'</p>',
            'is_published' => true,
            'published_at' => fake()->dateTimeBetween('-6 months'),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (): array => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }
}
