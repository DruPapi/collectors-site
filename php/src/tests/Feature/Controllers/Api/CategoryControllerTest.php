<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Category;
use App\Models\Collectible;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_GivenNoFilters_WhenFetched_ThenRespondsWithNoErrors(): void
    {
        Category::factory()->has(Collectible::factory()->count(5))->create();

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
