<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = Str::title(fake()->unique()->words(2, true));

        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'intro' => fake()->sentence(15),
            'body' => '<p>'.implode('</p><p>', fake()->paragraphs(3)).'</p>',
            'banner_image' => null,
            'meta_title' => $title,
            'meta_description' => fake()->sentence(20),
        ];
    }
}
