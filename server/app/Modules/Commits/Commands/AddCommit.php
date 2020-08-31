<?php

declare(strict_types=1);

namespace App\Modules\Commits\Commands;

use App\Modules\Commits\DTO\CommitDto;
use App\Modules\Commits\Models\Commit;
use App\Modules\Repositories\Models\Repository;

class AddCommit
{
    private $repository;
    private $dto;

    public function __construct(Repository $repository, CommitDto $dto)
    {
        $this->repository = $repository;
        $this->dto = $dto;
    }

    public function handle(): Commit
    {
        if ($commit = Commit::bySha($this->dto->sha())->byRepository($this->repository)->first()) {
            return $commit;
        }

        return Commit::create(array_merge(['repository_id' => $this->repository->id], $this->dto->toArray()));
    }
}
