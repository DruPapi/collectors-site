<?php

namespace App\Responses\Models;

use App\Responses\Models\Abstracts\ResponseModel;

class CollectibleListResponse extends ResponseModel
{
    protected array $visible = [
        'id',
        'name',
        'file_name',
        'value',
    ];

    protected array $appends = [
        'in_cart',
    ];
}
