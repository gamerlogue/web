<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Visibility;
use App\Models\GameList;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GameList>
 */
class GameListFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->optional()->sentence(),
            'visibility' => Visibility::Public,
            'is_ranked' => false,
        ];
    }

    public function private(): static
    {
        return $this->state(['visibility' => Visibility::Private]);
    }
}
