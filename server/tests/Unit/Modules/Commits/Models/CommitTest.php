<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Commits\Models;

use App\Modules\Commits\Models\Commit;
use App\Modules\Repositories\Models\Repository;
use App\Modules\Vendors\Models\Vendor;
use Tests\TestCase;

class CommitTest extends TestCase
{
    private Repository $repository;
    private Commit $commit;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = factory(Repository::class)->create();
        $this->commit = factory(Commit::class)->create(['repository_id' => $this->repository->id]);
    }

    /** @test */
    public function repository(): void
    {
        $this->assertSame($this->repository->id, $this->commit->repository->id);
    }

    /** @test */
    public function bySha(): void
    {
        factory(Commit::class)->create();

        $this->assertSame(1, Commit::bySha($this->commit->sha)->count());
        $this->assertSame(Commit::bySha($this->commit->sha)->first()->id, $this->commit->id);
    }

    /** @test */
    public function byRepository(): void
    {
        factory(Commit::class)->create();

        $this->assertSame(1, Commit::byRepository($this->commit->repository)->count());
        $this->assertSame(Commit::byRepository($this->commit->repository)->first()->id, $this->commit->id);
    }

    /** @test */
    public function cascadeDeleting(): void
    {
        $this->assertTrue($this->repository->exists());

        $this->repository->delete();

        $this->assertFalse(Repository::where('id', $this->repository->id)->exists());
        $this->assertFalse(Commit::where('id', $this->commit->id)->exists());
    }
}
