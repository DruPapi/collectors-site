<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
    public function getCategories(): Collection
    {
        return Category::query()
            ->orderBy('name')
            ->withCount('collectibles')
            ->get();
    }
}
