<?php

namespace Database\Factories;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    protected $model = Tour::class;
    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'uuid' => Str::uuid(),
            'startingDate' => now(),
            'endingDate' => now()->addDays(fake()->numberBetween(1, 5)),
            'price' => (fake()->numberBetween(1000, 2000)*100),
            'createdAt' => now(),
            'updatedAt' => now(),
        ];
    }
}
