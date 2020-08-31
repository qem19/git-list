<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Repositories\Commands;

use App\Modules\Repositories\Commands\DeleteRepository;
use App\Modules\Repositories\Models\Repository;
use Tests\TestCase;

class DeleteRepositoryTest extends TestCase
{
    /** @test */
    public function correctDelete(): void
    {
        $repository = factory(Repository::class)->create();
        $cmd = new DeleteRepository($repository);
        $cmd->handle();

        $this->assertFalse(Repository::where('id', $repository->id)->exists());
    }
}
