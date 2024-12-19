<?php

namespace App\Models;

use App\Models\Abstracts\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $collectible_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Collectible|null $collectible
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartItem query()
 * @method static \Database\Factories\CartItemFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';

    protected $attributes = [
        'quantity' => 1,
    ];

    protected $fillable = [
        'collectible_id',
        'quantity',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('own', function (Builder $q) {
            $q->where('user_id', '=', auth()->id() ?? 0);
        });
    }

    public static function byCollectibleId(int $collectibleId): self
    {
        return static::query()
            ->where('collectible_id', '=', $collectibleId)
            ->first() ?? new self(['collectible_id' => $collectibleId]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function collectible(): BelongsTo
    {
        return $this->belongsTo(Collectible::class);
    }
}
