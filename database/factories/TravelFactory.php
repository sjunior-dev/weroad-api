<?php

namespace Database\Factories;

use App\Models\Travel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Travel>
 */
class TravelFactory extends Factory
{
    protected $model = Travel::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        $slug = Str::of($name)->slug('-');
        $moods = [
            'nature' => fake()->numberBetween(10, 100),
            'relax' => fake()->numberBetween(10, 100),
            'history' => fake()->numberBetween(10, 100),
            'culture' => fake()->numberBetween(10, 100),
            'party' => fake()->numberBetween(10, 100),
        ];
        return [
            'name' => $name,
            'slug' => $slug,
            'uuid' => Str::uuid(),
            'description' => fake()->text(200),
            'moods' => $moods,
            'numberOfDays' => fake()->numberBetween(1, 10),
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
