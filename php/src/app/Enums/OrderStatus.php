<?php

namespace App\Enums;

use App\Enums\Traits\Arrayable;

enum OrderStatus: string
{
    use Arrayable;

    case Pending = 'pending';
    case Processed = 'processed';
    case Canceled = 'canceled';
}
