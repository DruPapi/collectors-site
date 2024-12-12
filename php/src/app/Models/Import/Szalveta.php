<?php

namespace App\Models\Import;

use App\Contracts\OnlyForDataImport;
use App\Models\Collectible;
use App\Models\Import\Abstracts\BaseImportModel;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property string $szalveta
 * @property int $darab
 * @property int|null $kategoria
 * @property string $kategoria2
 * @property int|null $kat2
 * @property int $csereertek
 * @property int $valid
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Szalveta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Szalveta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Szalveta query()
 *
 * @mixin \Eloquent
 */
class Szalveta extends BaseImportModel implements OnlyForDataImport
{
    public $table = 'szalvetak';

    public function getTargetModelName(): string
    {
        return Collectible::class;
    }

    public function toMappedRow(): array
    {
        return [
            'name' => $this->szalveta,
            'category_id' => $this->kat2,
            'item_type_id' => $this->kategoria,
            'is_public' => $this->valid,
            'value' => $this->csereertek,
            'quantity' => $this->darab,
        ];
    }

    protected function kat2(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value > 1 ? $value : null,
        );
    }

    protected function kategoria(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?: null,
        );
    }
}
