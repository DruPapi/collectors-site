<?php

namespace App\Responses\Api;

use App\Models\CartItem;
use App\Responses\Models\CartItemResponse as CartItemResponseModel;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use JustSteveKing\StatusCode\Http;

readonly class CartItemResponse implements Responsable
{
    public function __construct(
        public CartItem $cartItem,
        public Http $status = Http::OK,
    ) {}

    public function toResponse($request)
    {
        return new JsonResponse(
            data: $this->toResponseModel(),
            status: $this->status->value,
        );
    }

    private function toResponseModel(): CartItemResponseModel
    {
        return new CartItemResponseModel($this->cartItem);
    }
}
