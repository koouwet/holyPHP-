<?php

namespace Database\Factories;

use App\Models\Usage;
use App\Models\Thing;
use App\Models\Place;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Usage>
 */
class UsageFactory extends Factory
{
    protected $model = Usage::class;

    public function definition(): array
    {
        return [
            'thing_id' => Thing::factory(),
            'place_id' => Place::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'amount' => fake()->numberBetween(1, 10),
        ];
    }
}

