<?php

declare(strict_types=1);

namespace App\Modules\Repositories\Events;

use App\Modules\Repositories\Models\Repository;

class RepositoryCreated
{
    public $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }
}
