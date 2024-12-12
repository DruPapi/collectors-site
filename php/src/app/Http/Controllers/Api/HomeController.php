<?php

namespace App\Http\Controllers\Api;

use App\Models\Property;
use App\Responses\Api\HomeResponse;
use App\Services\OrderService;
use JustSteveKing\StatusCode\Http;

class HomeController extends Controller
{
    public function __construct(
        private OrderService $orderService,
    ) {}

    public function index(): HomeResponse
    {
        return new HomeResponse(
            numberOfExchanges: $this->orderService->getExchangedItemsCount(),
            collectorsSiteStartedAt: $this->orderService->getOldestExchangeDate(),
            content: Property::getValue(Property::HOME_CONTENT_NAME),
            status: Http::OK,
        );
    }
}
