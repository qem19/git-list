<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Repositories\Commands;

use App\Modules\Repositories\Commands\AddRepository;
use App\Modules\Vendors\Models\Vendor;
use Tests\TestCase;

class AddRepositoryTest extends TestCase
{
    /** @test */
    public function correctCreateWithoutRepeating(): void
    {
        $vendor = factory(Vendor::class)->create();
        $cmd = new AddRepository($vendor, 'test');
        $repository1 = $cmd->handle();
        $repository2 = $cmd->handle();

        $this->assertSame($repository1->id, $repository2->id);
    }
}
