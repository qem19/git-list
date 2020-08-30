<?php

declare(strict_types=1);

namespace App\Modules\Commits\Jobs;

use App\Modules\Commits\Commands\AddCommit;
use App\Modules\Commits\DTO\CommitDto;
use App\Modules\Repositories\Models\Repository;
use Github\Api\Repository\Commits;
use Illuminate\Bus\Dispatcher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;

class SyncCommitsByPage implements ShouldQueue
{
    use Dispatchable, Queueable;

    private const PER_PAGE = 100;
    private const DELAY_MINUTES = 2;

    private $repository;
    private $page;

    public function __construct(Repository $repository, int $page)
    {
        $this->repository = $repository;
        $this->page = $page;
    }

    public function handle(Commits $api, Dispatcher $dispatcher): void
    {
        $commits = $api->all(
            $this->repository->vendor->name,
            $this->repository->name,
            [
                'per_page' => self::PER_PAGE,
                'page' => $this->page,
            ]
        );

        foreach ($commits as $commit) {
            $dispatcher->dispatchNow(new AddCommit($this->repository, $this->formatCommit($commit)));
        }

        // check for last page
        if (count($commits) < self::PER_PAGE) {
            return;
        }

        // continue sync if it wasnt last page. Delay for github-api limits
        $delay = Carbon::now()->addMinutes(self::DELAY_MINUTES);
        self::dispatch($this->repository, ++$this->page)->delay($delay);
    }

    private function formatCommit(array $commit): CommitDto
    {
        $params = [
            'sha' => $commit['sha'],
            'description' => $commit['commit']['message'],
            'author' => $commit['commit']['author']['email'],
            'committed_at' => $commit['commit']['author']['date'],
        ];

        return new CommitDto($params);
    }
}
