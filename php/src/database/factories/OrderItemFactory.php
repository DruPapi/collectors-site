<?php

namespace Database\Factories;

use App\Models\Collectible;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Collectible>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'collectible_id' => Collectible::factory(),
            'order_id' => Order::factory(),
            'quantity' => 1,
            'value' => $this->faker->numberBetween(1, 3),
        ];
    }
}
