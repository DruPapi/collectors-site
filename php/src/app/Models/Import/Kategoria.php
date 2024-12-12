<?php

namespace App\Models\Import;

use App\Contracts\OnlyForDataImport;
use App\Models\Category;
use App\Models\Import\Abstracts\BaseImportModel;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property string $kategoria2
 * @property int $seged
 * @property int $ID
 *
 * @method static Builder<static>|Kategoria newModelQuery()
 * @method static Builder<static>|Kategoria newQuery()
 * @method static Builder<static>|Kategoria query()
 *
 * @mixin \Eloquent
 */
class Kategoria extends BaseImportModel implements OnlyForDataImport
{
    protected $table = 'kategoriak';

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('exists', function (Builder $q) {
            $q->where('seged', '=', '0');
        });
    }

    public function getTargetModelName(): string
    {
        return Category::class;
    }

    public function toMappedRow(): array
    {
        return [
            'id' => $this->ID,
            'name' => $this->kategoria2,
        ];
    }
}
