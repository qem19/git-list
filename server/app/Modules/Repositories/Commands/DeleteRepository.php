<?php

declare(strict_types=1);

namespace App\Modules\Repositories\Commands;

use App\Modules\Repositories\Models\Repository;

class DeleteRepository
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(): void
    {
        $this->repository->delete();
    }
}
