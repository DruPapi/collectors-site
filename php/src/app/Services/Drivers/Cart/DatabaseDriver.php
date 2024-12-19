<?php

namespace App\Services\Drivers\Cart;

use App\Models\CartItem;
use App\Models\Collectible;
use App\Services\Drivers\Contracts\InteractsWithCart;
use DB;
use Illuminate\Support\Collection;

class DatabaseDriver implements InteractsWithCart
{
    public function list(): Collection
    {
        return CartItem::query()
            ->with('collectible.itemType')
            ->orderBy('collectible_id', 'desc')
            ->get();
    }

    public function add(int $collectibleId, int $quantity): CartItem
    {
        $cartItem = CartItem::byCollectibleId($collectibleId);

        DB::transaction(function () use ($cartItem, $quantity) {
            $change = $quantity - $cartItem->quantity;
            $cartItem->quantity = $quantity;
            $cartItem->user_id = auth()->id();
            $cartItem->save();
            if ($change) {
                $cartItem->collectible()->decrement('quantity', $change);
            }
        });

        return $cartItem;
    }

    public function remove(int $collectibleId): bool
    {
        $cartItem = CartItem::query()
            ->where('collectible_id', '=', $collectibleId)
            ->with('collectible')
            ->first();

        if (!$cartItem || !$cartItem->collectible) {
            return true;
        }

        \DB::transaction(function () use ($cartItem) {
            $cartItem->collectible->increment('quantity', $cartItem->quantity);
            $cartItem->delete();
        });

        return true;
    }

    public function inCart(Collectible $collectible): int
    {
        return $collectible->cart->quantity ?? 0;
    }
}
