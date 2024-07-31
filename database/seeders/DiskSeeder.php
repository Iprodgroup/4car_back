<?php

namespace Database\Seeders;

use App\Models\Product\Disk;
use Illuminate\Database\Seeder;

class DiskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Disk::factory()->count(20)->create();
    }
}
