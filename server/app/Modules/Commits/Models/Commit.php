<?php

declare(strict_types=1);

namespace App\Modules\Commits\Models;

use App\Modules\Repositories\Models\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property-read string $sha
 * @property-read int $repository_id
 * @property-read string $description
 * @property-read string $author
 * @property-read Carbon $committed_at
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * Scopes:
 * @method self|Builder bySha(string $sha)
 * @method self|Builder byRepository(Repository $repository)
 */
class Commit extends Model
{
    protected $fillable = ['sha', 'repository_id', 'description', 'author', 'committed_at'];

    public function scopeBySha(Builder $query, string $sha): Builder
    {
        return $query->where('sha', $sha);
    }

    public function scopeByRepository(Builder $query, Repository $repository): Builder
    {
        return $query->where('repository_id', $repository->id);
    }
}
