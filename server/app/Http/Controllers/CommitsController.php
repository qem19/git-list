<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DeleteCommitsRequest;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Modules\Commits\Commands\DeleteCommit;
use App\Modules\Commits\Models\Commit;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommitsController extends Controller
{
    public function deleteByIds(DeleteCommitsRequest $request)
    {
        $commitIds = $request->validated()['commit_ids'];

        try {
            Commit::find($commitIds)->each(fn (Commit $commit) => $this->dispatchNow(new DeleteCommit($commit)));
        } catch (ModelNotFoundException $e) {
            return ErrorResponse::make('Some commits dont exist');
        }

        return SuccessResponse::make();
    }
}
