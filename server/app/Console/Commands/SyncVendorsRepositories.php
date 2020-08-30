<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Modules\Commits\Commands\SyncCommits;
use App\Modules\Repositories\Commands\AddRepository;
use App\Modules\Repositories\Queries\ExistsRepositoryInGithubQuery;
use App\Modules\Vendors\Commands\AddVendor;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class SyncVendorsRepositories extends Command
{
    use DispatchesJobs;

    private const VENDOR_PARAM = 'vendor';
    private const REPOSITORY_PARAM = 'repository';

    protected $signature = 'repository:sync {' . self::VENDOR_PARAM . '} {' . self::REPOSITORY_PARAM . '}';

    public function handle(ExistsRepositoryInGithubQuery $query): void
    {
        $vendorName = $this->argument(self::VENDOR_PARAM);
        $repositoryName = $this->argument(self::REPOSITORY_PARAM);

        if (!$query->fetch($vendorName, $repositoryName)) {
            $this->info('Vendor or repository doesnt exist');
            return;
        }

        $vendor = $this->dispatchNow(new AddVendor($vendorName));
        $repository = $this->dispatchNow(new AddRepository($vendor, $repositoryName));

        $this->dispatchNow(new SyncCommits($repository));

        $this->info('Sync has been started');
    }
}
