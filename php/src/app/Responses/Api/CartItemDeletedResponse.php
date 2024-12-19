<?php

namespace App\Responses\Api;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use JustSteveKing\StatusCode\Http;

readonly class CartItemDeletedResponse implements Responsable
{
    public function __construct(
        public bool $success,
        public Http $status = Http::OK,
    ) {}

    public function toResponse($request)
    {
        return new JsonResponse(
            data: $this->success,
            status: $this->status->value,
        );
    }
}
