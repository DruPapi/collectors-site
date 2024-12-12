<?php

namespace Tests\Feature\Controllers\Api;

use Tests\TestCase;

class CollectibleControllerTest extends TestCase
{
    public function test_GivenNoFilters_WhenFetched_ThenReturnsTheCorrectObjectStructure(): void
    {
        $response = $this->get('/api/collectibles');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'items' => [
                [
                    'id',
                    'name',
                    'file_name',
                    'value',
                    'in_cart',
                    'item_type',
                ],
            ],
            'current_page',
            'max_page',
        ]);
    }

    public function test_GivenNonExistingCategoryAndBigPageNumber_WhenFetched_ThenReturnsEmptyStructure(): void
    {
        $page = 1000;
        $categoryId = -1;

        $response = $this->get('/api/collectibles?category_id=' . $categoryId . '&page=' . $page);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'items' => [],
            'current_page',
            'max_page',
        ]);
        $response->assertExactJson([
            'items' => [],
            'current_page' => $page,
            'max_page' => 0,
        ]);
    }

    public function test_GivenNoAdditionalData_WhenFetched_ThenReturnsRequiredFields(): void
    {
        $itemId = 200;

        $response = $this->get('/api/collectibles/' . $itemId);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'item' => [
                'id',
                'name',
                'file_name',
                'value',
                'quantity',
                'in_cart',
                'type',
            ],
        ]);
    }

    public function test_GivenNonExistingItem_WhenFetched_ThenRespondsNotFound(): void
    {
        $itemId = 100000;

        $response = $this->get('/api/collectibles/' . $itemId);

        $response->assertStatus(404);
    }
}
