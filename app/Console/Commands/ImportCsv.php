<?php

namespace App\Console\Commands;

use League\Csv\Reader;
use App\Models\Product\Models;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
class ImportCsv extends Command
{
    protected $signature = 'import:csv {file}';
    protected $description = 'Import data from CSV file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $filePath = $this->argument('file');
        $this->importFromCsv($filePath);
    }

    private function importFromCsv($filePath)
    {
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        foreach ($records as $record) {
            Models::updateOrCreate(
                ['brand_id' => $record['Артикул']], // Уникальное поле для поиска записи
                [
                    'brand_name' => $record['Производитель'],
                    'name' => $record['Модель шины'],
                    'type' => $record['Категория'],
                    'shirina' => $record['Ширина шины'],
                    'visota' => $record['Высота'],
                    'diametr' => $record['Диаметр шины'],
                    'shipi' => $record['Шипы'],
                    'sezonnost' => $record['Сезонность'],
                    'index_n' => $record['Индекс нагрузки'],
                    'index_s' => $record['Индекс скорости'],
                    'runflat' => $record['RunFlat'],
                ]
            );
        }
        Log::info('Import completed successfully!');
    }
}
