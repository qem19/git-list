<?php

declare(strict_types=1);

namespace App\Modules\Vendors\Commands;

use App\Modules\Vendors\Models\Vendor;

class AddVendor
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function handle(): Vendor
    {
        if ($vendor = Vendor::byName($this->name)->first()) {
            return $vendor;
        }

        return Vendor::create(['name' => $this->name]);
    }
}
