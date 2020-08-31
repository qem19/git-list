<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Vendors\Models;

use App\Modules\Vendors\Models\Vendor;
use Tests\TestCase;

class VendorTest extends TestCase
{
    /** @test */
    public function byName(): void
    {
        $vendor = factory(Vendor::class)->create(['name' => 'test']);

        $this->assertSame(Vendor::byName('test')->first()->id, $vendor->id);
    }
}
