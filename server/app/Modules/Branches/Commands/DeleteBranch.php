<?php

declare(strict_types=1);

namespace App\Modules\Branches\Commands;

use App\Modules\Branches\Models\Branch;

class DeleteBranch
{
    private $branch;

    public function __construct(Branch $branch)
    {
        $this->branch = $branch;
    }

    public function handle(): void
    {
        $this->branch->delete();
    }
}
