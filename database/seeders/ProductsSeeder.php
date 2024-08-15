<?php

namespace Database\Seeders;

use League\Csv\Reader;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $csv = Reader::createFromPath(database_path('seeders/csv/tires.csv'), 'r');
        $csv->setHeaderOffset(0);



    }
}
