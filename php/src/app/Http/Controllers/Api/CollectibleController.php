<?php

namespace App\Http\Controllers\Api;

use App\Models\Property;
use App\Requests\CollectibleItemRequest;
use App\Requests\CollectibleListRequest;
use App\Responses\Api\CollectibleItemResponse;
use App\Responses\Api\CollectibleListResponse;
use App\Services\CollectibleService;
use App\ValueObjects\Page;

class CollectibleController extends Controller
{
    public function __construct(
        private readonly CollectibleService $collectibleService,
    ) {}

    public function index(CollectibleListRequest $request): CollectibleListResponse
    {
        $this->configureService($request);

        $page = $this->getPage($request);
        $categoryId = (int) $request->get('category_id');

        return new CollectibleListResponse(
            collectibles: $this->collectibleService->list($page, $categoryId),
            maxPage: $this->collectibleService->maxPage($page, $categoryId),
            currentPage: $page->current,
        );
    }

    public function show(CollectibleItemRequest $request, int $id): CollectibleItemResponse
    {
        $this->configureService($request);

        return new CollectibleItemResponse(
            collectibleItem: $this->collectibleService->getCollectible($id),
            previous: $this->collectibleService->previous($id, $request->category_id),
            next: $this->collectibleService->next($id, $request->category_id),
        );
    }

    private function getPage($request): Page
    {
        return new Page(
            current: (int) $request->get('page', 1),
            perPage: (int) Property::getValue(Property::DEFAULT_PAGE_SIZE_NAME),
        );
    }

    private function configureService($request): void
    {
        if ($request->has('order_by')) {
            $this->collectibleService->setOrderBy($request->validated('order_by'));
        }
        if ($request->has('order_direction')) {
            $this->collectibleService->setOrderDirection($request->validated('order_direction'));
        }
    }
}
