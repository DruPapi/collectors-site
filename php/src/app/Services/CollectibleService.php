<?php

namespace App\Services;

use App\Models\Collectible;
use App\ValueObjects\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CollectibleService
{
    public function list(Page $page, ?int $categoryId): Collection
    {
        return $this->prepareQuery($categoryId)
            ->with('itemType')
            ->orderBy('id', 'desc')
            ->limit($page->perPage)
            ->offset($page->offset)
            ->get();
    }

    public function maxPage(Page $page, ?int $categoryId): int
    {
        return (int) ceil(
            $this->prepareQuery($categoryId)->count() / $page->perPage
        );
    }

    private function prepareQuery(?int $categoryId): Builder
    {
        return Collectible::query()
            ->when($categoryId, fn ($q) => $q->where('category_id', '=', $categoryId));
    }
}
