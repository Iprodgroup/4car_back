<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'text' => $this->faker->paragraph,
            // 'contentTitle' => $this->faker->sentence,
            'date' => $this->faker->date,
            'image' => $this->faker->imageUrl(640, 480, 'cats'), // Пример с изображением
        ];
    }
}
