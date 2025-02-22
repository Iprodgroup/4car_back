<?php

namespace App\Console\Commands;

use App\Models\Product\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessXmlFiles extends Command
{
    protected $signature = 'process:xmlfiles';
    protected $description = 'Process XML files and update products table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $exchangeDir = storage_path('app/ftp');

        $files = scandir($exchangeDir);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $filePath = $exchangeDir . '/' . $file;

            if (pathinfo($filePath, PATHINFO_EXTENSION) === 'xml') {
                try {
                    $this->processXmlFile($filePath);
                   // unlink($filePath); // Удаляем файл после успешной обработки
                } catch (\Exception $e) {
                    Log::error("Ошибка при обработке файла $filePath: " . $e->getMessage());
                }
            }
            $this->info('Файл: ' . $filePath);
        }
        return 0;
    }

    private function processXmlFile($filePath)
    {
        $xml = simplexml_load_file($filePath);
        if ($xml === false) {
            Log::error("Ошибка загрузки XML файла: $filePath");
            foreach (libxml_get_errors() as $error) {
                Log::error($error->message);
            }
            return;
        }

        Log::info("Начало обработки данных из файла: $filePath");

        foreach ($xml->children() as $item) {
            if ($item->getName() === 'product') {
                $this->saveToDatabase($item, 'product');
            } elseif ($item->getName() === 'offer') {
                $this->saveToDatabase($item, 'offer');
            }
        }
    }

    private function saveToDatabase($item, $type)
    {
        try {
            $data = [
                'sku' => (string)$item['sku'],
                'name' => (string)$item->name,
                'type' => $type,
            ];

            if ($type === 'product') {
                $data['vidy_nomenklaturi'] = (string)$item->category;
                $data['brendy'] = (string)$item->vendor;
                $data['publish_in_kaspi'] = filter_var((string)$item->PublishInKaspi, FILTER_VALIDATE_BOOLEAN);
                $data['run_flat'] = filter_var((string)$item->RunFlat, FILTER_VALIDATE_BOOLEAN);
                $data['weight'] = (int)$item->weight;
                $data['modeli'] = (string)$item->model;
                $data['sezony'] = (int)$item->season;
                $data['shipy'] = filter_var((string)$item->spikes, FILTER_VALIDATE_BOOLEAN);

                if ($item->category == 'Летние шины' || $item->category == 'Зимние шины') {
                    $data['vysota_shin'] = (int)$item->height;
                    $data['diametr_shin'] = (int)$item->diameter;
                    $data['indeks_nagruzki'] = (string)$item->{'load-index'};
                    $data['indeks_skorosti'] = (string)$item->{'speed-index'};
                    $data['shirina_shin'] = (string)$item->width;
                } elseif ($item->category == 'Диски') {
                    $data['usileniye'] = (float)$item->overhang;
                    $data['diameter_shin'] = (int)$item->diameter;
                    $data['kolichestvo_boltov'] = (int)$item->{'count-bolt'};
                    $data['rasstoyaniya'] = (float)$item->{'spacing-bolt'};
                    $data['width'] = (float)$item->width;
                    $data['otverstiya'] = (float)$item->hole;
                    $data['cveta'] = (string)$item->colour;
                }
            } elseif ($type === 'offer') {
                $data['brendy'] = (string)$item->vendor;
                $data['stock_quantity'] = (int)$item->quantity;
                $data['price'] = (int)$item->price;
            }

            Product::updateOrCreate(
                ['sku' => $data['sku']],
                $data
            );
        } catch (\Exception $e) {
            Log::error("Ошибка при сохранении данных в базу данных: " . $e->getMessage());
        }
    }
}
