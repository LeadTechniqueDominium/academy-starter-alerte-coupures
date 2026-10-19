<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Commune;
use App\Models\Neighborhood;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Neighborhood>
 */
class NeighborhoodFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'commune_id' => Commune::factory(),
            'name' => 'Quartier '.fake()->unique()->lastName(),
        ];
    }
}
