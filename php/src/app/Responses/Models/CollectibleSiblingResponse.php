<?php

namespace App\Responses\Models;

use App\Responses\Models\Abstracts\ResponseModel;

class CollectibleSiblingResponse extends ResponseModel
{
    protected array $visible = [
        'id',
        'name',
        'file_name',
    ];
}
