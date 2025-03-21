<?php

namespace App\Listeners;

use App\Events\UserLogggedIn;
use App\Services\CartService;
use App\Services\Drivers\Cart\CartFactory;
use Illuminate\Validation\UnauthorizedException;

class UserLogggedInHandler
{
    /**
     * Create the event listener.
     */
    public function __construct(private readonly CartService $cart)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLogggedIn $event): void
    {
        if (!auth()->id()) {
            throw new UnauthorizedException();
        }

        $itemsAddedInCurrentSession = CartFactory::getDriverForUnauthenticated()
            ->list()
            ->keyBy('collectible_id');

        if ($itemsAddedInCurrentSession->isEmpty()) {
            return;
        }

        $itemsFromPreviousSession = CartFactory::getDriverForAuthenticated()
            ->list()
            ->keyBy('collectible_id');

        $this->cart->mergeCarts(
            source: $itemsAddedInCurrentSession,
            target: $itemsFromPreviousSession,
        );
    }
}
