<?php

declare(strict_types=1);

namespace App\Console;

use App\Jobs\UpdateWeatherJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

final class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new UpdateWeatherJob())->hourly();
    }
}
