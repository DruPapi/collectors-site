<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Collectible;
use Illuminate\Support\Collection;

class CartService
{
    public function getCollectibleIdsFromCart(): Collection
    {
        return CartItem::all()->pluck('quantity', 'collectible_id');
    }

    public function collectibleIsInCart(Collection $cart, Collectible $collectible): int
    {
        return $cart->get($collectible->id)->quantity ?? 0;
    }
}
