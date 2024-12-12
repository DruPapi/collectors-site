<?php

namespace App\Models;

use App\Models\Abstracts\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string|null $file_name
 * @property int|null $category_id
 * @property int|null $item_type_id
 * @property int $is_public
 * @property int $value
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\ItemType|null $itemType
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collectible newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collectible newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collectible onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collectible query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collectible withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collectible withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Collectible extends Model
{
    use SoftDeletes;

    protected $table = 'collectibles';

    protected function inCart(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->cart->quantity ?? 0,
        );
    }

    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->itemType->name ?? '',
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function itemType(): BelongsTo
    {
        return $this->belongsTo(ItemType::class);
    }

    public function cart(): HasOne
    {
        return $this->hasOne(CartItem::class);
    }
}
