<?php

declare(strict_types=1);

namespace App\Modules\Repositories\Models;

use App\Modules\Commits\Models\Commit;
use App\Modules\Vendors\Models\Vendor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property-read int $vendor_id
 * @property-read string $name
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * Relations:
 * @property-read Vendor $vendor
 * @property-read Collection|Commit[] $commits
 *
 * Scopes:
 * @method self|Builder byName(string $name)
 * @method self|Builder byVendor(Vendor $vendor)
 * @method self|Builder byVendorName(string $vendorName)
 */
class Repository extends Model
{
    protected $fillable = ['vendor_id', 'name'];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function commits(): HasMany
    {
        return $this->hasMany(Commit::class);
    }

    public function scopeByName(Builder $query, string $name): Builder
    {
        return $query->where('name', $name);
    }

    public function scopeByVendor(Builder $query, Vendor $vendor): Builder
    {
        return $query->where('vendor_id', $vendor->id);
    }

    public function scopeByVendorName(Builder $query, string $vendorName): Builder
    {
        return $query->whereHas('vendor', function ($query) use ($vendorName) {
            return $query->byName($vendorName);
        });
    }
}
