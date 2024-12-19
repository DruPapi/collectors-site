<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Models\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property int $total_value
 * @property int $total_quantity
 * @property OrderStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $orderItems
 * @property-read \App\Models\User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order withoutTrashed()
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'orders';

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
