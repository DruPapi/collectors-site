<?php

namespace App\Services;

use App\Models\CartItem;
use App\Services\Drivers\Cart\CartFactory;
use Illuminate\Database\Eloquent\Collection;

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

    public function mergeCarts(Collection $source, Collection $target): void
    {
        if ($target->isEmpty()) {
            $this->addAllFromSession($source);

            return;
        }

        $this->mergeSessionIntoDB($target, $source);
    }

    private function addAllFromSession(Collection $itemsAddedInCurrentSession): void
    {
        $driver = CartFactory::getDriverForAuthenticated();
        $itemsAddedInCurrentSession->each(function ($item) use ($driver) {
            /** @var CartItem $item */
            $driver->add($item->collectible_id, $item->quantity);
        });
    }

    private function mergeSessionIntoDB(Collection $target, Collection $source): void
    {
        $driver = CartFactory::getDriverForAuthenticated();
        $source->each(function ($item, $key) use ($target, $driver) {
            /** @var CartItem $item */
            if ($existingItem = $target->get($key)) {
                /** @var CartItem $existingItem */
                $existingItem->quantity = $item->quantity;
                $existingItem->save();

                return;
            }
            $driver->add($item->collectible_id, $item->quantity);
        });
    }
}
