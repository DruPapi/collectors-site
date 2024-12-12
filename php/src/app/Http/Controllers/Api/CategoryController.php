<?php

namespace App\Http\Controllers\Api;

use App\Responses\Api\CategoryListResponse;
use App\Services\CategoryService;
use JustSteveKing\StatusCode\Http;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService,
    ) {}

    public function index(): CategoryListResponse
    {
        return new CategoryListResponse(
            categories: $this->categoryService->getCategories(),
            status: Http::OK,
        );
    }
}
