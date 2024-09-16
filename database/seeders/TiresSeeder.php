<?php

namespace Database\Seeders;

use App\Models\Tire;
use League\Csv\Reader;
use Illuminate\Database\Seeder;

class TiresSeeder extends Seeder
{
    public function run(): void
    {
        $csv = Reader::createFromPath(database_path('seeders/csv/tires.csv'), 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            Tire::firstOrCreate([
                'id' => $record['Id'],
                'status' => $record['Status'],
                'code' => $record['Code'],
                'description' => $record['Description'],
                'is_replica' => $record['IsReplica'],
                'shirina' => $record['Shirina'],
                'visota' => $record['Visota'],
                'diametr' => $record['Diametr'],
                'item' => $record['Item'],
                'ext_code' => $record['ExtCode'],
            ]);
        }
    }
}
