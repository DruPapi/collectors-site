<?php

namespace App\Responses\Api;

use App\Models\Collectible;
use App\Responses\Models\CollectibleListResponse as CollectibleListResponseModel;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use JustSteveKing\StatusCode\Http;

class CollectibleResponse implements Responsable
{
    public function __construct(
        public readonly Collection $collectibles,
        public readonly int $maxPage,
        public readonly int $currentPage,
        public readonly Collection $cart,
        public readonly Http $status = Http::OK,
    ) {}

    public function toResponse($request)
    {
        return new JsonResponse(
            data: [
                'items' => $this->filteredCollectibleList(),
                'max_page' => $this->maxPage,
                'current_page' => $this->currentPage,
            ],
            status: $this->status->value,
        );
    }

    private function filteredCollectibleList(): Collection
    {
        return $this->collectibles
            ->map(
                fn (Collectible $collectible) => (new CollectibleListResponseModel($collectible))
                    ->withCart($this->cart)
            );
    }
}
