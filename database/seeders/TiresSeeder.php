<?php

namespace Database\Seeders;

use App\Models\Tires;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tires::factory()->count(20)->create();
    }
}
