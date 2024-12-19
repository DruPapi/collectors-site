<?php

namespace Database\Factories;

use App\Models\Collectible;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Collectible>
 */
class CartItemFactory extends Factory
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
            'user_id' => User::factory(),
            'quantity' => 1,
        ];
    }
}
