<?php

namespace Database\Seeders;

use League\Csv\Reader;
use App\Models\Product\Cars;
use Illuminate\Database\Seeder;

class CarsTableSeeder extends Seeder
{
    public function run(): void
    {
        $csv = Reader::createFromPath(base_path() . '/database/seeders/csv/cars.csv', 'r');
        $csv->setHeaderOffset(0);

         foreach ($csv as $record) {
             Cars::firstOrCreate([
                 'Id' => $record['Id'],
                 'Status' => $record['Status'],
                 'CarMarkCode' => $record['CarMarkCode'],
                 'CarMark' => $record['CarMark'],
                 'CarModelCode' => $record['CarModelCode'],
                 'CarModel' => $record['CarModel'],
                 'CarYear' => $record['CarYear'],
                 'CarModificationCode' => $record['CarModificationCode'],
                 'Processing' => $record['Processing'],
                 'DiskProcessed' => $record['DiskProcessed'],
                 'TireProcessed' => $record['TireProcessed'],
                 'Kuzov' => $record['Kuzov'],
                 'Dvigatel' => $record['Dvigatel'],
                 'krepezh' => $record['krepezh'] ?? null,
                 'krepezhraz' => $record['krepezhraz'] ?? null,
                 'krepezhraz2' => $record['krepezhraz2'] ?? null,
                 'counthole' => $record['counthole'] ?? null,
                 'pcd' => $record['pcd'] ?? null,
                 'dia' => $record['dia'] ?? null,
                 'diamax' => $record['diamax'] ?? null,
             ]);
         }
    }
}
