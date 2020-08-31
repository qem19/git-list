<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Commits\Commands;

use App\Modules\Commits\Commands\AddCommit;
use App\Modules\Commits\DTO\CommitDto;
use App\Modules\Repositories\Models\Repository;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AddCommitTest extends TestCase
{
    /** @test */
    public function correctCreateWithoutRepeating(): void
    {
        $repository = factory(Repository::class)->create();
        $dto = new CommitDto(['sha' => 'test', 'author' => 'mail.ru', 'description' => 'text', 'committed_at' => Carbon::now()]);
        $cmd = new AddCommit($repository, $dto);

        $commit1 = $cmd->handle();
        $commit2 = $cmd->handle();

        $this->assertSame($commit1->id, $commit2->id);
    }
}
