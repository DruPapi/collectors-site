<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Collectible;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_GivenNotLoggedInUser_WhenAddsItemToTheCart_ThenTheItemShowsItIsInCart(): void
    {
        $item = Collectible::factory()->create();
        $this->post('/api/cart/add', ['collectible_id' => $item->id, 'quantity' => 1]);

        $response = $this->get('/api/collectibles/' . $item->id);

        $response->assertStatus(200);
        $response->assertJsonPath('item.in_cart', 1);
    }

    public function test_GivenNotLoggedInUser_WhenListsTheCart_ThenTheItemShowsItIsInCart(): void
    {
        $item = Collectible::factory()->create();
        $this->post('/api/cart/add', ['collectible_id' => $item->id, 'quantity' => 1]);

        $response = $this->get('/api/cart');

        $response->assertStatus(200);
        $response->assertJsonPath('items.0.collectible.id', 1);
    }

    public function test_GivenNotLoggedInUser_WhenDeletesFromTheCart_ThenTheItemDoesNotShowsItIsInCart(): void
    {
        $item = Collectible::factory()->create();
        $this->post('/api/cart/add', ['collectible_id' => $item->id, 'quantity' => 1]);
        $this->delete('/api/cart/remove', ['collectible_id' => $item->id]);

        $response = $this->get('/api/cart');

        $response->assertStatus(200);
        $this->assertEmpty($response->json('items'));
    }

    public function test_GivenLoggedInUser_WhenAddsItemToTheCart_ThenTheItemShowsItIsInCart(): void
    {
        $user = User::factory()->create();
        Auth::login($user);
        $item = Collectible::factory()->create();
        $this->post('/api/cart/add', ['collectible_id' => $item->id, 'quantity' => 1]);

        $response = $this->get('/api/collectibles/' . $item->id);

        $response->assertStatus(200);
        $response->assertJsonPath('item.in_cart', 1);
    }

    public function test_GivenLoggedInUser_WhenDeletesFromTheCart_ThenTheItemDoesNotShowsItIsInCart(): void
    {
        $user = User::factory()->create();
        Auth::login($user);
        $item = Collectible::factory()->create();
        $this->post('/api/cart/add', ['collectible_id' => $item->id, 'quantity' => 1]);
        $this->delete('/api/cart/remove', ['collectible_id' => $item->id]);

        $response = $this->get('/api/cart');

        $response->assertStatus(200);
        $this->assertEmpty($response->json('items'));
    }
}
