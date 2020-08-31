<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Repositories\Queries;

use App\Modules\Repositories\Models\Repository;
use App\Modules\Repositories\Queries\ExistsRepositoryInGithubQuery;
use Github\Api\User;
use Tests\TestCase;

class ExistsRepositoryInGithubQueryTest extends TestCase
{
    /** @test */
    public function hasInDb(): void
    {
        $repository = factory(Repository::class)->create();

        $query = $this->app->make(ExistsRepositoryInGithubQuery::class);

        $this->assertTrue($query->fetch($repository->vendor->name, $repository->name));
    }

    /** @test */
    public function doesntHaveInDb(): void
    {
        $repositoryName = 'testRepo';
        $mock = $this->createMock(User::class);
        $mock->expects($this->once())->method('repositories')->willReturn([['name' => $repositoryName]]);

        $query = new ExistsRepositoryInGithubQuery($mock);

        $this->assertTrue($query->fetch('testVendor', $repositoryName));
    }
}
