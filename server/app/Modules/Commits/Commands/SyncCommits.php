<?php

declare(strict_types=1);

namespace App\Modules\Commits\Commands;

use App\Modules\Commits\Jobs\SyncCommitsByPage;
use App\Modules\Repositories\Models\Repository;

class SyncCommits
{
    private const FIRST_PAGE = 1;

    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(): void
    {
        SyncCommitsByPage::dispatch($this->repository, self::FIRST_PAGE);
    }
}
