<?php

declare(strict_types=1);

namespace Tests\Feature\EventHandlers;

use App\Events\UserLogggedIn;
use App\Listeners\UserLogggedInHandler;
use App\Models\CartItem;
use App\Models\Collectible;
use App\Models\User;
use App\Services\Drivers\Cart\CartFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserLoggedInHandlerTest extends TestCase
{
    use RefreshDatabase;

    public function test_GivenNoExistingCartItemButNew_WhenLoggingIn_ThenTheNewIsAdded(): void
    {
        $sessionCart = CartFactory::getDriverForUnauthenticated();
        $dbCart = CartFactory::getDriverForAuthenticated();
        $collectibles = Collectible::factory()->count(5)->create();
        $collectibles->each(fn ($item) => $sessionCart->add($item->id, 1));
        $sesssionItems = $sessionCart->list()->sortBy('collectible_id');

        $this->loginAsCustomer();
        with(app()->make(UserLogggedInHandler::class))->handle(new UserLogggedIn());
        $dbItems = $dbCart->list()->sortBy('collectible_id');

        $this->assertEquals($sesssionItems->pluck('collectible_id')->all(), $dbItems->pluck('collectible_id')->all());
        $this->assertEquals($sesssionItems->pluck('quantity')->all(), $dbItems->pluck('quantity')->all());
    }

    public function test_GivenExistingCartItemButNoNew_WhenLoggingIn_ThenNothingChanged(): void
    {
        $user = User::factory()->create();
        $dbCart = CartFactory::getDriverForAuthenticated();
        $previousItems = CartItem::factory()->count(5)->create(['user_id' => $user->id]);

        $this->loginAsCustomer($user);
        with(app()->make(UserLogggedInHandler::class))->handle(new UserLogggedIn());
        $currentItems = $dbCart->list()->sortBy('collectible_id');

        $this->assertEquals($previousItems->pluck('collectible_id')->all(), $currentItems->pluck('collectible_id')->all());
        $this->assertEquals($previousItems->pluck('quantity')->all(), $currentItems->pluck('quantity')->all());
    }

    public function test_GivenBothPreviousAndSessionCartItems_WhenLoggingIn_ThenTheyAreMerged(): void
    {
        $onlyInDB = 3;
        $inBothPlaces = 2;
        $onlyFromSession = 3;
        $sessionQuantity = 3;
        $accumulatedQuantity = $onlyInDB + ($inBothPlaces + $onlyFromSession) * $sessionQuantity;

        $user = User::factory()->create();
        $dbCart = CartFactory::getDriverForAuthenticated();
        $sessionCart = CartFactory::getDriverForUnauthenticated();
        $previousItems = CartItem::factory()->count($onlyInDB + $inBothPlaces)->create(['user_id' => $user->id]);

        $collectiblesInBoth = $previousItems->take($inBothPlaces);
        $collectiblesInBoth->each(fn ($item) => $sessionCart->add($item->id, $sessionQuantity));
        $sessionCollectibles = Collectible::factory()->count($onlyFromSession)->create();
        $sessionCollectibles->each(fn ($item) => $sessionCart->add($item->id, $sessionQuantity));
        $currentCollectibleIds = collect([
            ...$previousItems->pluck('collectible_id')->all(),
            ...$collectiblesInBoth->pluck('collectible_id')->all(),
            ...$sessionCollectibles->pluck('id')->all(),
        ])->unique()->values()->all();

        $this->loginAsCustomer($user);
        with(app()->make(UserLogggedInHandler::class))->handle(new UserLogggedIn());

        $inDB = $dbCart->list();
        $storedCollectibleIds = $inDB->pluck('collectible_id')->sort()->values()->all();
        $storedAccumulated = $inDB->pluck('quantity')->sum();

        $this->assertEquals($currentCollectibleIds, $storedCollectibleIds);
        $this->assertEquals($accumulatedQuantity, $storedAccumulated);
    }
}
