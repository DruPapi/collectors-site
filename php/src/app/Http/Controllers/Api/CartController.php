<?php

namespace App\Http\Controllers\Api;

use App\Requests\AddToCartRequest;
use App\Requests\RemoveFromCartRequest;
use App\Responses\Api\CartItemDeletedResponse;
use App\Responses\Api\CartItemResponse;
use App\Responses\Api\CartListResponse;
use App\Services\CartService;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
    ) {}

    public function index(): CartListResponse
    {
        return new CartListResponse(
            cartItems: $this->cartService->list(),
        );
    }

    public function add(AddToCartRequest $request): CartItemResponse
    {
        return new CartItemResponse(
            cartItem: $this->cartService->add($request->get('collectible_id'), $request->get('quantity'))
        );
    }

    public function remove(RemoveFromCartRequest $request): CartItemDeletedResponse
    {
        return new CartItemDeletedResponse(
            success: $this->cartService->remove($request->get('collectible_id'))
        );
    }
}
