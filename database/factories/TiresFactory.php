<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tires>
 */
class TiresFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'brand' => $this->faker->sentence,
            'model' => $this->faker->sentence,
            'weight' => Str::random(2),
            'height' => Str::random(2),
            'radius'=> Str::random(2),
            'spikes' => $this->faker->title(),
            'index_n' => $this->faker->randomDigit(),
            'index_s' => $this->faker->randomDigit(),
            'run_flat' => $this->faker->sentence,
            'country' => $this->faker->sentence,
            'year' => $this->faker->date(),
            'price' => $this->faker->sentence,
            'image' => $this->faker->sentence,
        ];
    }
}
