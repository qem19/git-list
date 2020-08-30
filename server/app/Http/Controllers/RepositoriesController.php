<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CommitsRequest;
use App\Http\Requests\SyncRepositoriesRequest;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Modules\Commits\Commands\SyncCommits;
use App\Modules\Repositories\Commands\AddRepository;
use App\Modules\Repositories\Models\Repository;
use App\Modules\Repositories\Queries\ExistsRepositoryInGithubQuery;
use App\Modules\Vendors\Commands\AddVendor;

class RepositoriesController extends Controller
{
    private const COMMITS_PER_PAGE = 20;
    private const FIRST_PAGE = 1;

    public function index()
    {
        $repositories = Repository::with('vendor')
            ->orderBy('vendor_id')
            ->get()
            ->map(fn (Repository $repository) => [
                'id' => $repository->id,
                'name' => $repository->name,
                'vendor_name' => $repository->vendor->name,
            ]);

        return SuccessResponse::makeFromCollection($repositories);
    }

    public function commits(Repository $repository, CommitsRequest $request)
    {
        $page = $request->validated()['page'] ?? self::FIRST_PAGE;

        $commits = collect($repository
            ->commits()
            ->orderBy('committed_at', 'desc')
            ->paginate(self::COMMITS_PER_PAGE, ['*'], 'page', (int) $page)
            ->items())
            ->map
            ->toArray();

        $meta = [
            'per_page' => self::COMMITS_PER_PAGE,
            'total' => $repository->commits()->count(),
        ];

        return SuccessResponse::makeFromCollection($commits, '', compact('meta'));
    }

    public function sync(SyncRepositoriesRequest $request, ExistsRepositoryInGithubQuery $query)
    {
        $params = $request->validated();

        if (!$query->fetch($params['vendor'], $params['repository'])) {
            return ErrorResponse::make('Vendor or repository doesnt exist');
        }

        $vendor = $this->dispatchNow(new AddVendor($params['vendor']));
        $repository = $this->dispatchNow(new AddRepository($vendor, $params['repository']));

        $this->dispatchNow(new SyncCommits($repository));

        return SuccessResponse::make();
    }
}
