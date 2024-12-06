<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Product\Manufacturer;

class LinkManufacturerModels extends Command
{
    protected $signature = 'link:manufacturer-models';
    protected $description = 'Интерактивное связывание производителей и моделей';

    public function handle()
    {
        while (true) {
            $manufacturers = Manufacturer::pluck('name', 'id');
            $this->info('Список производителей:');
            foreach ($manufacturers as $id => $name) {
                $this->line("[$id] $name");
            }

            $manufacturerId = $this->ask('Введите ID производителя (или "exit" для завершения)');

            if ($manufacturerId === 'exit') break;

            $manufacturer = Manufacturer::find($manufacturerId);
            if (!$manufacturer) {
                $this->error('Производитель не найден!');
                continue;
            }

            $modelInput = $this->ask('Введите модели через запятую');
            $models = array_map('trim', explode(',', $modelInput));

            $updatedCount = DB::table('models')
                ->whereIn('name', $models)
                ->update([
                    'brand_id' => $manufacturerId,
                    'updated_at' => Carbon::now()
                ]);
            $this->info("Обновлено моделей: $updatedCount");
        }

        $this->info('Связывание завершено.');
    }
}
