<?php

namespace App\Responses\Api\Errors;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use JustSteveKing\StatusCode\Http;

readonly class ValidationErrorResponse implements Responsable
{
    public function __construct(
        public ValidationException $exception,
        public Http $status = Http::BAD_REQUEST,
    ) {}

    public function toResponse($request)
    {
        return new JsonResponse(
            data: [
                'errors' => $this->exception->validator->errors(),
            ],
            status: $this->status->value,
        );
    }
}
