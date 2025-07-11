<?php

namespace App\Responses\Api;

use App\Models\Collectible;
use App\Responses\Models\CollectibleListResponse as CollectibleListResponseModel;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use JustSteveKing\StatusCode\Http;

readonly class CollectibleListResponse implements Responsable
{
    public function __construct(
        public Collection $collectibles,
        public int $maxPage,
        public int $currentPage,
        public Http $status = Http::OK,
    ) {}

    public function toResponse($request)
    {
        return new JsonResponse(
            data: [
                'items' => $this->toResponseModels(),
                'max_page' => $this->maxPage,
                'current_page' => $this->currentPage,
            ],
            status: $this->status->value,
        );
    }

    private function toResponseModels(): Collection
    {
        return $this->collectibles
            ->map(fn (Collectible $collectible) => new CollectibleListResponseModel($collectible));
    }
}
