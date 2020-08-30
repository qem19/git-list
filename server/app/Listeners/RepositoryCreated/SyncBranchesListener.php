<?php

declare(strict_types=1);

namespace App\Listeners\RepositoryCreated;

use App\Modules\Branches\Commands\SyncBranches;
use App\Modules\Repositories\Events\RepositoryCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;

class SyncBranchesListener implements ShouldQueue
{
    use DispatchesJobs;

    public function handle(RepositoryCreated $event): void
    {
        $this->dispatchNow(new SyncBranches($event->repository));
    }
}
