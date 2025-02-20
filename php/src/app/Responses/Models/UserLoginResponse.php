<?php

namespace App\Responses\Models;

use App\Responses\Models\Abstracts\ResponseModel;

class UserLoginResponse extends ResponseModel
{
    protected array $visible = [
        'id',
        'name',
    ];
}
