<?php

declare(strict_types=1);

namespace App\Modules\Commits\Commands;

use App\Modules\Branches\Models\Branch;
use Github\Api\Repository\Commits;

class SyncCommits
{
    private $branch;

    public function __construct(Branch $branch)
    {
        $this->branch = $branch;
    }

    public function handle(Commits $api): void
    {
        dd($api->all($this->branch->vendor->name, $this->branch->repository, ['sha' => $this->branch->name]));
    }
}
