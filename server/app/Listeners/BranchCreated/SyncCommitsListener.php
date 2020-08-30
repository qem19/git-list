<?php

declare(strict_types=1);

namespace App\Listeners\BranchCreated;

use App\Modules\Branches\Events\BranchCreated;
use App\Modules\Commits\Commands\SyncCommits;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;

class SyncCommitsListener implements ShouldQueue
{
    use DispatchesJobs;

    public function handle(BranchCreated $event): void
    {
        $this->dispatchNow(new SyncCommits($event->branch));
    }
}
