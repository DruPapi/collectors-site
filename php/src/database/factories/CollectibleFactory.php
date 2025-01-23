<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\ItemType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Collectible>
 */
class CollectibleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->filePath(),
            'file_name' => fake()->filePath(),
            'category_id' => Category::factory(),
            'item_type_id' => ItemType::factory(),
            'is_public' => true,
            'value' => fake()->numberBetween(1, 3),
            'quantity' => fake()->numberBetween(1, 10),
        ];
    }

    public function withCategory(int $id)
    {
        return $this->state(fn (array $attributes) => [
            'category_id' => $id,
        ]);
    }
}
