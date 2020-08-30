<?php

declare(strict_types=1);

namespace App\Modules\Repositories\Queries;

use App\Modules\Repositories\Models\Repository;
use Github\Api\User;

class ExistsRepositoryInGithubQuery
{
    private $api;

    public function __construct(User $api)
    {
        $this->api = $api;
    }

    public function fetch(string $vendor, string $repository): bool
    {
        if (Repository::byVendorName($vendor)->byName($repository)->exists()) {
            return true;
        }

        return collect($this->api->repositories($vendor))->contains('name', $repository);
    }
}
