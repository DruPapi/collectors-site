<?php

namespace App\Services\Drivers\Cart;

use App\Services\Drivers\Contracts\InteractsWithCart;

class CartFactory
{
    public static function get(): InteractsWithCart
    {
        return auth()->id()
            ? app()->make(DatabaseDriver::class)
            : app()->make(SessionDriver::class);
    }
}
