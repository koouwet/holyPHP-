<?php

namespace Database\Factories;

use App\Models\Thing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Thing>
 */
class ThingFactory extends Factory
{
    protected $model = Thing::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word() . ' #' . fake()->numberBetween(1, 999),
            'description' => fake()->sentence(),
            'wrnt' => fake()->optional()->dateTimeBetween('now', '+2 years'),
            'master_id' => User::inRandomOrder()->first()->id,
        ];
    }
}


