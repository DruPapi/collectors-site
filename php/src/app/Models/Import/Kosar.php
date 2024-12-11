<?php

namespace App\Models\Import;

use App\Contracts\OnlyForDataImport;
use App\Models\CartItem;
use App\Models\Collectible;
use App\Models\Import\Abstracts\BaseImportModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $userID
 * @property string $szalveta
 * @property int|null $darab
 * @property-read Collectible|null $collectible
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kosar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kosar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kosar query()
 *
 * @mixin \Eloquent
 */
class Kosar extends BaseImportModel implements OnlyForDataImport
{
    protected $table = 'kosar';

    public function getTargetModelName(): string
    {
        return CartItem::class;
    }

    public function toMappedRow(): array
    {
        return [
            'user_id' => $this->userID,
            'collectible_id' => $this->collectible?->id,
        ];
    }

    public function collectible(): BelongsTo
    {
        return $this->belongsTo(Collectible::class, 'szalveta', 'name');
    }
}
