<?php

namespace Tests\Feature\Controllers\Api;

use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    public function test_GivenNoFilters_WhenFetched_ThenRespondsWithNoErrors(): void
    {
        $response = $this->get('/api/categories');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'items' => [
                [
                    'id',
                    'name',
                    'collectibles_count',
                ],
            ],
        ]);
    }
}
