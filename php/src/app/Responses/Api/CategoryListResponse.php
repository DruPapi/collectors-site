<?php

namespace App\Responses\Api;

use App\Models\Category;
use App\Responses\Models\CategoryListResponse as CategoryListResponseModel;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use JustSteveKing\StatusCode\Http;

class CategoryListResponse implements Responsable
{
    public function __construct(
        public readonly Collection $categories,
        public readonly Http $status = Http::OK,
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
        return $this->categories
            ->map(fn (Category $category) => new CategoryListResponseModel($category));
    }
}
