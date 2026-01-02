<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'elixir_cost' => fake()->numberBetween(1, 9),
            'rarity' => fake()->randomElement(['Commune', 'Rare', 'Épique', 'Légendaire', 'Champion']),
        ];
    }
}
