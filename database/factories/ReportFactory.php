<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Incident;
use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Report>
 */
class ReportFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'incident_id' => Incident::factory(),
            'description' => 'Plus de courant depuis ce matin dans toute la rue.',
            'phone' => '07'.fake()->numerify('########'),
        ];
    }
}
