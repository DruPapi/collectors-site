<?php

namespace App\Services;

use App\Enums\DBOrder;
use App\Exceptions\Model\FieldNotExistsException;
use App\Models\Collectible;
use App\ValueObjects\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Schema;

class CollectibleService
{
    private string $orderBy = 'id';

    private DBOrder $orderDirection = DBOrder::desc;

    public function list(Page $page, ?int $categoryId): Collection
    {
        return $this->prepareQuery($categoryId)
            ->with(['itemType', 'cart'])
            ->orderBy($this->orderBy, $this->orderDirection->value)
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

    public function getCollectible(int $id): Collectible
    {
        return $this->prepareQuery()
            ->with(['itemType', 'cart'])
            ->findOrFail($id);
    }

    public function previous(int $id, ?int $categoryId): ?Collectible
    {
        return $this->prepareQuery($categoryId)
            ->where($this->orderBy, $this->orderDirection->invert()->comparisonOperator(), $id)
            ->orderBy($this->orderBy, $this->orderDirection->invert()->value)
            ->first();
    }

    public function next(int $id, ?int $categoryId): ?Collectible
    {
        return $this->prepareQuery($categoryId)
            ->where($this->orderBy, $this->orderDirection->comparisonOperator(), $id)
            ->orderBy($this->orderBy, $this->orderDirection->value)
            ->first();
    }

    public function setOrderBy(string $order): void
    {
        if (!Schema::hasColumn((new Collectible)->getTable(), $order)) {
            throw new FieldNotExistsException('Field "' . $order . '" not exists');
        }

        $this->orderBy = $order;
    }

    public function setOrderDirection(string $orderDirection): void
    {
        if ($direction = DBOrder::tryFrom($orderDirection)) {
            $this->orderDirection = $direction;
        }
    }

    /**
     * @return Builder<Collectible>
     */
    private function prepareQuery(?int $categoryId = null): Builder
    {
        return Collectible::query()
            ->when($categoryId, fn ($q) => $q->where('category_id', '=', $categoryId));
    }
}
