<?php

namespace App\Responses\Api;

use App\Models\Collectible;
use App\Responses\Models\CollectibleItemResponse as CollectibleItemResponseModel;
use App\Responses\Models\CollectibleSiblingResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use JustSteveKing\StatusCode\Http;

readonly class CollectibleItemResponse implements Responsable
{
    public function __construct(
        public Collectible $collectibleItem,
        public ?Collectible $previous,
        public ?Collectible $next,
        public Http $status = Http::OK,
    ) {}

    public function toResponse($request)
    {
        return new JsonResponse(
            data: [
                'item' => $this->toResponseModel(),
                'previous' => $this->toSiblingResponseModel($this->previous),
                'next' => $this->toSiblingResponseModel($this->next),
            ],
            status: $this->status->value,
        );
    }

    private function toResponseModel(): CollectibleItemResponseModel
    {
        return new CollectibleItemResponseModel($this->collectibleItem);
    }

    private function toSiblingResponseModel(?Collectible $sibling): ?CollectibleSiblingResponse
    {
        return $sibling
            ? new CollectibleSiblingResponse($sibling)
            : null;
    }
}
