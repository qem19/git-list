<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Vendors\Commands;

use App\Modules\Vendors\Commands\AddVendor;
use Tests\TestCase;

class AddVendorTest extends TestCase
{
    /** @test */
    public function correctCreateWithoutRepeating(): void
    {
        $cmd = new AddVendor('test');
        $vendor1 = $cmd->handle();
        $vendor2 = $cmd->handle();

        $this->assertSame($vendor1->id, $vendor2->id);
    }
}
