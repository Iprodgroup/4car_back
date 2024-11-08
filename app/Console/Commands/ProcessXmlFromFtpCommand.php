<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Admin\ProductController;

class ProcessXmlFromFtpCommand extends Command
{
    protected $signature = 'xml:process-ftp';
    protected $description = 'Process XML files from FTP storage';

    public function handle()
    {
        $ftpDir = 'ftp'; // Путь к директории в storage/app/ftp

        $files = Storage::files($ftpDir);

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'xml') {
                $fullPath = storage_path('app/' . $file);

                try {
                    $productController = new ProductController();
                    $productController->processXmlFile($fullPath);

                    Log::info("XML файл обработан: $file");

                    $archiveDir = 'ftp/archive/' . date('Y-m-d');
                    Storage::makeDirectory($archiveDir);
                    Storage::move($file, $archiveDir . '/' . pathinfo($file, PATHINFO_BASENAME));

                } catch (\Exception $e) {
                    // Логируем ошибки
                    Log::error("Ошибка обработки XML: " . $e->getMessage());
                }
            }
        }
    }
}
