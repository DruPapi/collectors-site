<?php

namespace Tests\Feature\Controllers\Api;

use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    public function test_GivenNoAdditionalSettings_WhenRequestingHome_ThenAllPropertiesAreSet(): void
    {
        $response = $this->get('/api/home');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'content',
            'number_of_exchanges',
            'collectors_site_started_at',
        ]);
    }
}
