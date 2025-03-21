<?php

namespace App\Services\Drivers\Cart;

use App\Models\CartItem;
use App\Models\Collectible;
use App\Services\Drivers\Contracts\InteractsWithCart;
use Illuminate\Database\Eloquent\Collection;
use Session;

class SessionDriver implements InteractsWithCart
{
    public function list(): Collection
    {
        $items = new Collection();
        foreach ($this->getCartItemsArray() as $item) {
            $items->push($item);
        }
        $items->load('collectible.itemType');

        return $items;
    }

    public function add(int $collectibleId, int $quantity): CartItem
    {
        $cartItem = new CartItem([
            'collectible_id' => $collectibleId,
            'quantity' => $quantity,
        ]);
        Session::put('cart_items.' . $cartItem->collectible_id, $cartItem);

        return $cartItem;
    }

    public function remove(int $collectibleId): bool
    {
        Session::forget('cart_items.' . $collectibleId);

        return true;
    }

    public function inCart(Collectible $collectible): int
    {
        return Session::get('cart_items.' . $collectible->id . '.quantity', 0);
    }

    private function getCartItemsArray(): array
    {
        return Session::get('cart_items', []);
    }
}
