<?php

namespace Database\Seeders;

use League\Csv\Reader;
use App\Models\Product\Brand;
use Illuminate\Database\Seeder;

class TiresSeeder extends Seeder
{

    public function run(): void
    {
        $csv = Reader::createFromPath(database_path('seeders/csv/tires.csv'), 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            Brand::firstOrCreate(['name' => $record['Brand']]);
        }
    }
}
