<?php

namespace App\Responses\Models;

use App\Responses\Models\Abstracts\ResponseModel;

class CartItemResponse extends ResponseModel
{
    protected array $visible = [
        'id',
        'quantity',
        'collectible',
    ];

    protected array $visibleOnCollectible = [
        'id',
        'name',
        'file_name',
        'value',
        'type',
    ];

    public function toArray()
    {
        $this->childModel->collectible?->append('type');

        $result = parent::toArray();
        $result['collectible'] = \Arr::only($result['collectible'] ?? [], $this->visibleOnCollectible);

        return $result;
    }
}
