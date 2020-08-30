<?php

declare(strict_types=1);

namespace App\Modules\Repositories\Commands;

use App\Modules\Repositories\Models\Repository;
use App\Modules\Vendors\Models\Vendor;
use Github\Api\User;
use Illuminate\Foundation\Bus\DispatchesJobs;

class SyncRepositories
{
    use DispatchesJobs;

    private $vendor;

    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function handle(User $api): void
    {
        $currentRepositories = collect($api->repositories($this->vendor->name))->keyBy('name');
        $appRepositories = Repository::byVendor($this->vendor)->get()->keyBy('name');

        $needCreateRepositories = $currentRepositories->diffKeys($appRepositories);

        foreach ($needCreateRepositories as $repository) {
            $this->dispatchNow(new AddRepository($this->vendor, $repository['name']));
        }

        $needDeleteRepositories = $appRepositories->diffKeys($currentRepositories);

        foreach ($needDeleteRepositories as $repository) {
            $this->dispatchNow(new DeleteRepository($repository));
        }
    }
}
