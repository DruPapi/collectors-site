<?php

namespace App\Models\Import;

use App\Contracts\OnlyForDataImport;
use App\Enums\OrderStatus;
use App\Models\Collectible;
use App\Models\Import\Abstracts\BaseImportModel;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $userID
 * @property string $szalveta
 * @property int $darab
 * @property string $datum
 * @property int $teljesitett
 * @property-read string $hour_of_the_order
 * @property-read Collectible|null $collectible
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rendeles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rendeles newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rendeles query()
 *
 * @mixin \Eloquent
 */
class Rendeles extends BaseImportModel implements OnlyForDataImport
{
    protected $table = 'rendeles';

    public function getTargetModelName(): string
    {
        return Order::class;
    }

    public function toMappedRow(): array
    {
        return [
            'user_id' => $this->userID,
            'status' => $this->teljesitett == 1 ? OrderStatus::Processed : OrderStatus::Pending,
        ];
    }

    public function toMappedOrderItem(): array
    {
        return [
            'quantity' => $this->darab,
            'collectible_id' => $this->collectible?->id,
            'value' => $this->collectible->value ?? 1,
        ];
    }

    public function totalValue(): int
    {
        return ($this->collectible->value ?? 1) * $this->darab;
    }

    public function collectible(): BelongsTo
    {
        return $this->belongsTo(Collectible::class, 'szalveta', 'name');
    }
}
