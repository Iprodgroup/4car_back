<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Admin\ProductController;
use App\Services\TelegramNotificationService;

class ProcessXmlFromFtpCommand extends Command
{
    protected $signature = 'xml:process-ftp';
    protected $description = 'Process XML files from FTP storage';

    protected $telegramService;

    public function __construct(TelegramNotificationService $telegramService)
    {
        parent::__construct();
        $this->telegramService = $telegramService;
    }

    public function handle()
    {
        $startTime = now();
        $processedFiles = 0;
        $errorFiles = 0;

        try {
            $ftpDir = 'ftp';
            $files = Storage::files($ftpDir);

            $message = "🤖 XML Processing Started:\n";
            $message .= "🕒 Start Time: " . $startTime . "\n";
            $message .= "📂 Total Files Found: " . count($files);

            $this->telegramService->sendMessage($message);

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

                        $processedFiles++;
                    } catch (\Exception $e) {
                        Log::error("Ошибка обработки XML: " . $e->getMessage());
                        $errorFiles++;
                    }
                }
            }

            $endTime = now();
            $duration = $startTime->diffInSeconds($endTime);

            $resultMessage = "✅ XML Processing Report:\n";
            $resultMessage .= "🕒 Start Time: {$startTime}\n";
            $resultMessage .= "🏁 End Time: {$endTime}\n";
            $resultMessage .= "⏱️ Duration: {$duration} seconds\n";
            $resultMessage .= "📄 Processed Files: {$processedFiles}\n";
            $resultMessage .= "❌ Error Files: {$errorFiles}";

            $this->telegramService->sendMessage($resultMessage);

        } catch (\Exception $e) {
            $errorMessage = "❌ XML Processing Global Error:\n";
            $errorMessage .= "🔥 Error: " . $e->getMessage();
            $this->telegramService->sendMessage($errorMessage);

            Log::error('XML Processing Global Error: ' . $e->getMessage());
        }
    }
}
