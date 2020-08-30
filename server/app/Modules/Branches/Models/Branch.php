<?php

declare(strict_types=1);

namespace App\Modules\Branches\Models;

use App\Modules\Repositories\Models\Repository;
use App\Modules\Vendors\Models\Vendor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read int $repository_id
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * Relations:
 * @property-read Repository $repository
 *
 * Attributes:
 * @property-read Vendor $vendor
 *
 * Scopes:
 * @method self|Builder byName(string $name)
 * @method self|Builder byRepository(Repository $repository)
 */
class Branch extends Model
{
    protected $fillable = ['name', 'repository_id'];

    public function getVendorAttribute(): Vendor
    {
        return $this->repository->vendor;
    }

    public function repository(): BelongsTo
    {
        return $this->belongsTo(Repository::class);
    }

    public function scopeByName(Builder $query, string $name): Builder
    {
        return $query->where('name', $name);
    }

    public function scopeByRepository(Builder $query, Repository $repository): Builder
    {
        return $query->where('repository_id', $repository->id);
    }
}
