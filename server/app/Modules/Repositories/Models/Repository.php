<?php

declare(strict_types=1);

namespace App\Modules\Repositories\Models;

use App\Modules\Vendors\Models\Vendor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property-read int $vendor_id
 * @property-read string $name
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * Relations:
 * @property-read Vendor $vendor
 *
 * Scopes:
 * @method self|Builder byName(string $name)
 * @method self|Builder byVendor(Vendor $vendor)
 */
class Repository extends Model
{
    protected $fillable = ['vendor_id', 'name'];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function scopeByName(Builder $query, string $name): Builder
    {
        return $query->where('name', $name);
    }

    public function scopeByVendor(Builder $query, Vendor $vendor): Builder
    {
        return $query->where('vendor_id', $vendor->id);
    }
}
