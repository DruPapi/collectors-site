<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Carbon;

class OrderService
{
    public function getExchangedItemsCount(): int
    {
        return OrderItem::count();
    }

    public function getOldestExchangeDate(): Carbon
    {
        return Order::orderBy('created_at')->first()->created_at;
    }
}
