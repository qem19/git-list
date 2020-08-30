<?php

declare(strict_types=1);

namespace App\Modules\Branches\Commands;

use App\Modules\Branches\Models\Branch;
use App\Modules\Repositories\Models\Repository;
use Github\Api\Repo;
use Illuminate\Foundation\Bus\DispatchesJobs;

class SyncBranches
{
    use DispatchesJobs;

    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Repo $api): void
    {
        $currentBranches = collect($api->branches($this->repository->vendor->name, $this->repository->name))->keyBy(
            'name'
        );
        $appBranches = Branch::byRepository($this->repository)->get()->keyBy('name');

        $needCreateBranches = $currentBranches->diffKeys($appBranches);

        foreach ($needCreateBranches as $branch) {
            $this->dispatchNow(new AddBranch($this->repository, $branch['name']));
        }

        $needDeleteBranches = $appBranches->diffKeys($currentBranches);

        foreach ($needDeleteBranches as $branch) {
            $this->dispatchNow(new DeleteBranch($branch));
        }
    }
}
