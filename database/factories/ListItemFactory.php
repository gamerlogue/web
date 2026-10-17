<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\GameList;
use App\Models\ListItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ListItem>
 */
class ListItemFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'list_id' => GameList::factory(),
            'game_id' => fake()->unique()->numberBetween(1, 1_000_000),
            'note' => null,
        ];
    }
}
