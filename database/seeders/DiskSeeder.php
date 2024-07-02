<?php

namespace Database\Seeders;

use App\Models\Disk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
