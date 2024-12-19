<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Collectible;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_GivenNoAdditionalSettings_WhenRequestingHome_ThenAllPropertiesAreSet(): void
    {
        Order::factory()->has(OrderItem::factory()->has(Collectible::factory()))->count(20)->create();

        $response = $this->get('/api/home');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'content',
            'number_of_exchanges',
            'collectors_site_started_at',
        ]);
    }
}
