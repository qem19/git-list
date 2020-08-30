<?php

declare(strict_types=1);

namespace App\Modules\Branches\Events;

use App\Modules\Branches\Models\Branch;

class BranchCreated
{
    public $branch;

    public function __construct(Branch $branch)
    {
        $this->branch = $branch;
    }
}
