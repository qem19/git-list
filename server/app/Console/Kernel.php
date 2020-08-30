<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\ListCommits;
use App\Console\Commands\SyncVendorsRepositories;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [SyncVendorsRepositories::class, ListCommits::class];

    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
