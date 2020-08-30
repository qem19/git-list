<?php

declare(strict_types=1);

namespace App\Modules\Commits\Commands;

use App\Modules\Commits\Models\Commit;

class DeleteCommit
{
    private $commit;

    public function __construct(Commit $commit)
    {
        $this->commit = $commit;
    }

    public function handle(): void
    {
        $this->commit->delete();
    }
}
