<?php

namespace App\Responses\Models;

use App\Responses\Models\Abstracts\ResponseModel;

class CollectibleItemResponse extends ResponseModel
{
    protected array $visible = [
        'id',
        'name',
        'file_name',
        'value',
        'quantity',
    ];

    protected array $appends = [
        'in_cart',
        'type',
    ];
}
