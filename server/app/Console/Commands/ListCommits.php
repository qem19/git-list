<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Modules\Commits\Models\Commit;
use App\Modules\Repositories\Models\Repository;
use Illuminate\Console\Command;
use Illuminate\Contracts\Pagination\Paginator;

class ListCommits extends Command
{
    private const VENDOR_PARAM = 'vendor';
    private const REPOSITORY_PARAM = 'repository';

    private const COMMITS_PER_PAGE = 10;
    private const FIRST_PAGE = 1;

    protected $signature = 'repository:commits {' . self::VENDOR_PARAM . '} {' . self::REPOSITORY_PARAM . '}';

    private ?Repository $repository;

    public function handle()
    {
        $vendorName = $this->argument(self::VENDOR_PARAM);
        $repositoryName = $this->argument(self::REPOSITORY_PARAM);

        $this->repository = Repository::byName($repositoryName)->byVendorName($vendorName)->first();

        if ($this->repository === null) {
            $this->error('This repository havent been synced yet');
            return;
        }

        $currentPage = self::FIRST_PAGE;
        $paginator = $this->fetchCommits($currentPage);

        while (true) {
            $this->outputCommits($paginator->items());

            if (!$paginator->hasMorePages()) {
                return;
            }

            if ($this->confirm('Press Enter for next page', true)) {
                $paginator = $this->fetchCommits(++$currentPage);
                continue;
            }

            return;
        }
    }

    private function outputCommits(array $commits): void
    {
        /** @var Commit $commit */
        foreach ($commits as $commit) {
            $this->info("{$commit->description} - by {$commit->author} - {$commit->sha}");
        }
    }

    private function fetchCommits(int $page): Paginator
    {
        return $this->repository
            ->commits()
            ->orderBy('committed_at', 'desc')
            ->paginate(self::COMMITS_PER_PAGE, ['*'], 'page', $page);
    }
}
