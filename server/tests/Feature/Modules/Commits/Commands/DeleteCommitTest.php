<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Commits\Commands;

use App\Modules\Commits\Commands\DeleteCommit;
use App\Modules\Commits\Models\Commit;
use Tests\TestCase;

class DeleteCommitTest extends TestCase
{
    /** @test */
    public function correctDelete(): void
    {
        $commit = factory(Commit::class)->create();

        (new DeleteCommit($commit))->handle();

        $this->assertFalse(Commit::where('id', $commit->id)->exists());
    }
}
