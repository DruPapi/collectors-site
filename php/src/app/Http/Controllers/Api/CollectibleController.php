<?php

namespace App\Http\Controllers\Api;

use App\Models\Property;
use App\Responses\Api\CollectibleResponse;
use App\Services\CartService;
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

    public function index(): CollectibleResponse
    {
        $page = new Page(
            current: (int) $this->request->get('page', 1),
            perPage: (int) Property::getValue(Property::DEFAULT_PAGE_SIZE_NAME),
        );
        $categoryId = (int) $this->request->get('category_id');

        return new CollectibleResponse(
            collectibles: $this->collectibleService->list($page, $categoryId),
            maxPage: $this->collectibleService->maxPage($page, $categoryId),
            currentPage: $page->current,
            cart: $this->cartService->getCollectibleIdsFromCart(),
        );
    }
}
