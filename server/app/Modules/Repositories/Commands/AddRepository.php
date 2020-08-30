<?php

declare(strict_types=1);

namespace App\Modules\Repositories\Commands;

use App\Modules\Repositories\Models\Repository;
use App\Modules\Vendors\Models\Vendor;

class AddRepository
{
    private $vendor;
    private $name;

    public function __construct(Vendor $vendor, string $name)
    {
        $this->vendor = $vendor;
        $this->name = $name;
    }

    public function handle(): Repository
    {
        if ($repository = Repository::byName($this->name)->byVendor($this->vendor)->first()) {
            return $repository;
        }

        return Repository::create([
            'vendor_id' => $this->vendor->id,
            'name' => $this->name,
        ]);
    }
}
