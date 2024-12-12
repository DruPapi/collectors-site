<?php

namespace App\Http\Controllers\Api;

use App\Models\Property;
use App\Responses\Api\CollectibleItemResponse;
use App\Responses\Api\CollectibleListResponse;
use App\Services\CollectibleService;
use App\ValueObjects\Page;
use Illuminate\Http\Request;

class CollectibleController extends Controller
{
    public function __construct(
        private readonly Request $request,
        private readonly CollectibleService $collectibleService,
        private readonly CartService $cartService,
    ) {}

    public function index(): CollectibleListResponse
    {
        $page = new Page(
            current: (int) $this->request->get('page', 1),
            perPage: (int) Property::getValue(Property::DEFAULT_PAGE_SIZE_NAME),
        );
        $categoryId = (int) $this->request->get('category_id');

        return new CollectibleListResponse(
            collectibles: $this->collectibleService->list($page, $categoryId),
            maxPage: $this->collectibleService->maxPage($page, $categoryId),
            currentPage: $page->current,
        );
    }

    public function show(int $id): CollectibleItemResponse
    {
        return new CollectibleItemResponse(
            collectibleItem: $this->collectibleService->getCollectible($id),
        );
    }
}
