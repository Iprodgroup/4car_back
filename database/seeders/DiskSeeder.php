<?php

namespace Database\Seeders;

use App\Models\Disk;
use League\Csv\Reader;
use Illuminate\Database\Seeder;

class DiskSeeder extends Seeder
{
    public function run(): void
    {
        $csv = Reader::createFromPath(base_path() . '/database/seeders/csv/disks.csv', 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            Disk::firstOrCreate([
                'id' => $record['Id'],
                'status' => $record['Status'],
                'code' => $record['Code'],
                'description' => $record['Description'],
                'is_replica' => $record['IsReplica'],
                'shirina' => $record['Shirina'],
                'diametr' => $record['Diametr'],
                'vylet1' => $record['Vylet1'],
                'vylet2' => $record['Vylet2'],
                'boltov' => $record['Boltov'],
                'rasstoyanie' => $record['Rasstoyanie'],
                'item' => $record['Item'],
                'dia' => $record['Dia'],
                'gayka' => $record['Gayka'],
                'ext_code' => $record['ExtCode'],
            ]);
    }
}
}
