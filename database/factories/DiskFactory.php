<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Disk>
 */
class DiskFactory extends Factory
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
            'type' => $this->faker->sentence,
            'size' => Str::random(2),
            'brand' => Str::random(2),
            'model'=> Str::random(2),
            'number_of_holes' => $this->faker->title(),
            'size_of_holes' => $this->faker->title(),
            'width' => $this->faker->randomDigit(),
            'diametr' => $this->faker->randomDigit(),
            'departure' => $this->faker->sentence,
            'tco' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(1000, 20000),
            'image' => $this->faker->sentence,
        ];
    }
}
