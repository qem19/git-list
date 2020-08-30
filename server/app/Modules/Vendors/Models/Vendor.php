<?php

declare(strict_types=1);

namespace App\Modules\Vendors\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * Scopes:
 * @method self|Builder byName(string $name)
 */
class Vendor extends Model
{
    protected $fillable = ['name'];

    public function scopeByName(Builder $query, string $name): Builder
    {
        return $query->where('name', $name);
    }
}
