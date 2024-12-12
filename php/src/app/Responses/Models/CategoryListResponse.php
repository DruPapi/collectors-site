<?php

namespace App\Responses\Models;

use App\Responses\Models\Abstracts\ResponseModel;

class CategoryListResponse extends ResponseModel
{
    protected array $visible = [
        'id',
        'name',
        'collectibles_count',
    ];
}
