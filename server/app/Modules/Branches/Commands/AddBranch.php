<?php

declare(strict_types=1);

namespace App\Modules\Branches\Commands;

use App\Modules\Branches\Events\BranchCreated;
use App\Modules\Branches\Models\Branch;
use App\Modules\Repositories\Models\Repository;

class AddBranch
{
    private $repository;
    private $name;

    public function __construct(Repository $repository, string $name)
    {
        $this->repository = $repository;
        $this->name = $name;
    }

    public function handle(): void
    {
        if (Branch::byName($this->name)->byRepository($this->repository)->exists()) {
            return;
        }

        $branch = Branch::create([
            'name' => $this->name,
            'repository_id' => $this->repository->id,
        ]);

        event(new BranchCreated($branch));
    }
}
