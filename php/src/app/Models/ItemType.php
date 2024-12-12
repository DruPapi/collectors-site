<?php

namespace App\Models;

use App\Models\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Collectible> $collectibles
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemType withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemType withoutTrashed()
 *
 * @mixin \Eloquent
 */
class ItemType extends Model
{
    use SoftDeletes;

    protected $table = 'item_types';

    public function collectibles(): HasMany
    {
        return $this->hasMany(Collectible::class);
    }
}
