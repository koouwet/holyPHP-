<?php

namespace Database\Factories;

use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Place>
 */
class PlaceFactory extends Factory
{
    protected $model = Place::class;

    public function definition(): array
    {
        return [
            'name' => 'Place ' . fake()->word(),
            'description' => fake()->optional()->sentence(),
            'repair' => fake()->boolean(20), // примерно 20% ремонт/мойка
            'work' => fake()->boolean(30), // примерно 30% в работе
        ];
    }
}

