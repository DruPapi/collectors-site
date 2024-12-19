<?php

namespace App\Services\Drivers\Contracts;

use App\Models\CartItem;
use App\Models\Collectible;
use Illuminate\Support\Collection;

interface InteractsWithCart
{
    public function list(): Collection;

    public function add(int $collectibleId, int $quantity): CartItem;

    public function remove(int $collectibleId): bool;

    public function inCart(Collectible $collectible): int;
}
