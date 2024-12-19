<?php

namespace App\Responses\Api;

use App\Models\CartItem;
use App\Responses\Models\CartItemResponse as CartItemResponseModel;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use JustSteveKing\StatusCode\Http;

readonly class CartListResponse implements Responsable
{
    public function __construct(
        public Collection $cartItems,
        public Http $status = Http::OK,
    ) {}

    public function toResponse($request)
    {
        return new JsonResponse(
            data: [
                'items' => $this->toResponseModels(),
            ],
            status: $this->status->value,
        );
    }

    private function toResponseModels(): Collection
    {
        return $this->cartItems
            ->map(fn (CartItem $cartItem) => new CartItemResponseModel($cartItem));
    }
}
