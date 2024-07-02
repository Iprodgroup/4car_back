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
            'model' => $this->faker->sentence, 
            'weight' => Str::random(2),  
            'height' => Str::random(2), 
            'diametr'=> Str::random(2),
            'season' => $this->faker->title(), 
            'spikes' => $this->faker->title(), 
            'index_n' => $this->faker->sentence, 
            'index_s' => $this->faker->sentence, 
            'run_flat' => $this->faker->sentence,
            'image' => $this->faker->sentence,
        ];
    }
}
