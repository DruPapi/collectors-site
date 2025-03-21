<?php

namespace App\Services\Drivers\Cart;

use App\Services\Drivers\Contracts\InteractsWithCart;

class CartFactory
{
    public static function get(): InteractsWithCart
    {
        return auth()->id()
            ? self::getDriverForAuthenticated()
            : self::getDriverForUnauthenticated();
    }

    public static function getDriverForAuthenticated(): InteractsWithCart
    {
        return app()->make(DatabaseDriver::class);
    }

    public static function getDriverForUnauthenticated(): InteractsWithCart
    {
        return app()->make(SessionDriver::class);
    }
}
