<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\IncidentStatus;
use App\Enums\OutageType;
use App\Models\Incident;
use App\Models\Neighborhood;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Incident>
 */
class IncidentFactory extends Factory
{
    /**
     * Par défaut : une coupure d'électricité en cours, commencée il y a une heure.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => OutageType::Electricity,
            'neighborhood_id' => Neighborhood::factory(),
            'status' => IncidentStatus::Active,
            'started_at' => now()->subHour(),
            'resolved_at' => null,
        ];
    }

    public function water(): static
    {
        return $this->state(fn (array $attributes) => ['type' => OutageType::Water]);
    }

    public function resolved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => IncidentStatus::Resolved,
            'resolved_at' => now(),
        ]);
    }
}
