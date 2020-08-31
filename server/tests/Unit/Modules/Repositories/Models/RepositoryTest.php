<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Repositories\Models;

use App\Modules\Commits\Models\Commit;
use App\Modules\Repositories\Models\Repository;
use App\Modules\Vendors\Models\Vendor;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    private Vendor $vendor;
    private Repository $repository;
    private Commit $commit;

    protected function setUp(): void
    {
        parent::setUp();

        $this->vendor = factory(Vendor::class)->create();
        $this->repository = factory(Repository::class)->create(['vendor_id' => $this->vendor->id]);
        $this->commit = factory(Commit::class)->create(['repository_id' => $this->repository->id]);
    }

    /** @test*/
    public function vendor(): void
    {
        $this->assertSame($this->vendor->id, $this->repository->vendor->id);
    }

    /** @test */
    public function commits(): void
    {
        $this->assertSame(1, $this->repository->commits()->count());
        $this->assertSame($this->commit->id, $this->repository->commits()->first()->id);
    }

    /** @test */
    public function byName(): void
    {
        factory(Repository::class)->create();

        $this->assertSame(1, Repository::byName($this->repository->name)->count());
        $this->assertSame(Repository::byName($this->repository->name)->first()->id, $this->repository->id);
    }

    /** @test */
    public function byVendor(): void
    {
        factory(Repository::class)->create();

        $this->assertSame(1, Repository::byVendor($this->vendor)->count());
        $this->assertSame(Repository::byVendor($this->vendor)->first()->id, $this->repository->id);
    }

    /** @test */
    public function byVendorName(): void
    {
        factory(Repository::class)->create();

        $this->assertSame(1, Repository::byVendorName($this->vendor->name)->count());
        $this->assertSame(Repository::byVendorName($this->vendor->name)->first()->id, $this->repository->id);
    }

    /** @test */
    public function cascadeDeleting(): void
    {
        $this->assertTrue($this->vendor->exists());
        $this->assertTrue($this->repository->exists());

        $this->vendor->delete();

        $this->assertFalse(Vendor::where('id', $this->vendor->id)->exists());
        $this->assertFalse(Repository::where('id', $this->repository->id)->exists());
    }
}
