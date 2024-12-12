<?php

namespace App\Responses\Models;

use App;
use App\Responses\Models\Abstracts\ResponseModel;
use App\Services\CartService;
use Illuminate\Support\Collection;

class CollectibleListResponse extends ResponseModel
{
    protected array $visible = [
        'id',
        'name',
        'file_name',
        'value',
    ];

    private Collection $cart;

    public function withCart(Collection $cart): ResponseModel
    {
        $this->cart = $cart;

        return $this;
    }

    public function toArray()
    {
        $cartService = App::make(CartService::class);

        return array_merge(
            parent::toArray(),
            [
                'in_cart' => $cartService->collectibleIsInCart($this->cart, $this->childModel),
                'item_type' => $this->childModel->itemType->name,
            ],
        );
    }
}
