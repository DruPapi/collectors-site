<?php

namespace App\Responses\Api;

use App\Models\Collectible;
use App\Responses\Models\CollectibleItemResponse as CollectibleItemResponseModel;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use JustSteveKing\StatusCode\Http;

readonly class CollectibleItemResponse implements Responsable
{
    public function __construct(
        public Collectible $collectibleItem,
        public Http $status = Http::OK,
    ) {}

    public function toResponse($request)
    {
        return new JsonResponse(
            data: [
                'item' => $this->toResponseModel(),
            ],
            status: $this->status->value,
        );
    }

    private function toResponseModel(): CollectibleItemResponseModel
    {
        return new CollectibleItemResponseModel($this->collectibleItem);
    }
}
