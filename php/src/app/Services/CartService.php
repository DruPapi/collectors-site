<?php

namespace App\Services;

use App\Models\CartItem;
use App\Services\Drivers\Cart\CartFactory;
use Illuminate\Support\Collection;

class CartService
{
    public function list(): Collection
    {
        return CartFactory::get()
            ->list();
    }

    public function add(int $collectibleId, int $quantity): CartItem
    {
        return CartFactory::get()
            ->add($collectibleId, $quantity);
    }

    public function remove(int $collectibleId): bool
    {
        return CartFactory::get()
            ->remove($collectibleId);
    }
}
