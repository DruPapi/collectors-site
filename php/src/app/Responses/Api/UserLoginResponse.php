<?php

namespace App\Responses\Api;

use App\Responses\Models\UserLoginResponse as UserLoginResponseModel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use JustSteveKing\StatusCode\Http;

readonly class UserLoginResponse implements Responsable
{
    public function __construct(
        public Authenticatable $user,
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

    private function toResponseModel(): UserLoginResponseModel
    {
        return new UserLoginResponseModel($this->user);
    }
}
