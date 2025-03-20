<?php

namespace App\Actions;

use App\Contracts\OnlyForDataImport;
use App\Models\Import\Rendeles;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class CreatesOrdersByItems implements OnlyForDataImport
{
    public function execute(): void
    {
        $orders = $this->collectOrders();
        foreach ($orders as $order) {
            $oldItems = $this->getItemsForOrder($order);
            if ($oldItems->isEmpty()) {
                return;
            }

            $order = (new Order())->forceFill($oldItems->first()->toMappedRow());
            $order->save();

            $totalValue = 0;
            $totalQuantity = 0;

            $oldItems->each(function (Rendeles $oldItem) use ($order, &$totalValue, &$totalQuantity) {
                $orderItem = (new OrderItem())
                    ->forceFill($oldItem->toMappedOrderItem());
                $orderItem->order_id = $order->id;
                $orderItem->created_at = new Carbon($oldItem->datum);
                $orderItem->save();

                $totalValue += $oldItem->totalValue();
                $totalQuantity += $oldItem->darab;
            });

            $order->created_at = $oldItems->first()->datum;
            $order->total_value = $totalValue;
            $order->total_quantity = $totalQuantity;
            $order->save();
        }
    }

    private function collectOrders(): Collection
    {
        return Rendeles::query()
            ->selectRaw('date_format(datum, \'%Y-%m-%d %H:00:00\') as hour_of_the_order')
            ->addSelect('userID')
            ->groupBy('hour_of_the_order', 'userID')
            ->get();
    }

    private function getItemsForOrder(Rendeles $order): Collection
    {
        $hourOfTheOrder = new Carbon($order->hour_of_the_order);

        return Rendeles::query()
            ->whereBetween(
                'datum',
                [
                    $hourOfTheOrder->format('Y-m-d H:i:s'),
                    $hourOfTheOrder->addHour()->addMinute()->format('Y-m-d H:i:s'),
                ]
            )
            ->where('userId', '=', $order->userID)
            ->with('collectible')
            ->get();
    }
}
