<?php

namespace Database\Factories;

use App\Enums\PostStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
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
        return [
            'title' => fake()->sentence,
            'content' => fake()->paragraphs(3, true),
            'summary' => fake()->text(200),
            'status' => PostStatusEnum::ACTIVE,
            'published_at' => now()->subDay(),
        ];
    }
}
