<?php

namespace App\Models\Import\Abstracts;

use App\Contracts\OnlyForDataImport;
use Illuminate\Database\Eloquent\Model;

abstract class BaseImportModel extends Model implements OnlyForDataImport
{
    public $timestamps = false;

    abstract public function getTargetModelName(): string;

    abstract public function toMappedRow(): array;
}
