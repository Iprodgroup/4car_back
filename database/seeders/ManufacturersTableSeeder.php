<?php

namespace Database\Seeders;

use League\Csv\Reader;
use League\Csv\Exception;
use Illuminate\Database\Seeder;
use League\Csv\UnavailableStream;
use App\Models\Product\Manufacturer;

class ManufacturersTableSeeder extends Seeder
{
    public function run(): void
    {
        $csv = Reader::createFromPath(database_path('seeders/csv/manufacturers.csv'), 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            Manufacturer::firstOrCreate(['name' => $record['Brand']]);
        }
    }
}
