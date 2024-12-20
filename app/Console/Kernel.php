<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('orders:export-xml')->everyTenMinutes();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        \App\Console\Commands\LinkManufacturerModels::class;
        // require base_path('routes/console.php');
    }
}
