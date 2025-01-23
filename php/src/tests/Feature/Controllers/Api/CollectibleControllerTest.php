<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Category;
use App\Models\Collectible;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CollectibleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_GivenNoFilters_WhenFetched_ThenReturnsTheCorrectObjectStructure(): void
    {
        Category::factory()->has(Collectible::factory()->count(5))->create();

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
        Category::factory()->has(Collectible::factory()->count(5))->create();

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
        Category::factory()->has(Collectible::factory()->count(5))->create();
        $itemId = Collectible::orderBy('category_id', 'desc')->orderBy('id')->first()->id;

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
            'previous',
            'next',
        ]);
    }

    public function test_GivenNonExistingItem_WhenFetched_ThenRespondsNotFound(): void
    {
        $itemId = 100000;

        $response = $this->get('/api/collectibles/' . $itemId);

        $response->assertStatus(404);
    }

    public function test_GivenNoCategory_WhenOrderedAsc_ThenRespondsWithCorrectSiblingIds(): void
    {
        Collectible::factory()
            ->count(5)
            ->create();

        $noPreviousExpected = $this->get('api/collectibles/1?order_direction=asc');
        $bothExpected = $this->get('api/collectibles/3?order_direction=asc');
        $noNextExpected = $this->get('api/collectibles/5?order_direction=asc');

        $this->assertNull($noPreviousExpected->json('previous.id'));
        $this->assertEquals(2, $bothExpected->json('previous.id'));
        $this->assertEquals(4, $bothExpected->json('next.id'));
        $this->assertNull($noNextExpected->json('next.id'));
    }

    public function test_GivenNoCategory_WhenOrderedDesc_ThenRespondsWithCorrectSiblingIds(): void
    {
        Collectible::factory()
            ->count(5)
            ->create();

        $noNextExpected = $this->get('api/collectibles/1?order_direction=desc');
        $bothExpected = $this->get('api/collectibles/3?order_direction=desc');
        $noPreviousExpected = $this->get('api/collectibles/5?order_direction=desc');

        $this->assertNull($noNextExpected->json('next.id'));
        $this->assertEquals(4, $bothExpected->json('previous.id'));
        $this->assertEquals(2, $bothExpected->json('next.id'));
        $this->assertNull($noPreviousExpected->json('previous.id'));
    }

    public function test_GivenCategory_WhenCategoryProvidedAndOrderedAsc_ThenRespondsWithCorrectSiblingIds(): void
    {
        Category::factory()
            ->has(
                Collectible::factory()->count(5)
            )->count(3)
            ->create();
        Collectible::factory()
            ->withCategory(1)
            ->count(5)
            ->create();

        $skipsOtherCategoriesNext = $this->get('api/collectibles/5?order_direction=asc&category_id=1');
        $skipsOtherCategoriesPrevious = $this->get('api/collectibles/16?order_direction=asc&category_id=1');

        $this->assertEquals(16, $skipsOtherCategoriesNext->json('next.id'));
        $this->assertEquals(5, $skipsOtherCategoriesPrevious->json('previous.id'));
    }

    public function test_GivenCategory_WhenCategoryProvidedAndOrderedDesc_ThenRespondsWithCorrectSiblingIds(): void
    {
        Category::factory()
            ->has(
                Collectible::factory()->count(5)
            )->count(3)
            ->create();
        Collectible::factory()
            ->withCategory(1)
            ->count(5)
            ->create();

        $skipsOtherCategoriesPreviousReverse = $this->get('api/collectibles/5?order_direction=desc&category_id=1');
        $skipsOtherCategoriesNextReverse = $this->get('api/collectibles/16?order_direction=desc&category_id=1');

        $this->assertEquals(16, $skipsOtherCategoriesPreviousReverse->json('previous.id'));
        $this->assertEquals(5, $skipsOtherCategoriesNextReverse->json('next.id'));
    }
}
