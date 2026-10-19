<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Neighborhood;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subscriber>
 */
class SubscriberFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone' => '05'.fake()->numerify('########'),
            'neighborhood_id' => Neighborhood::factory(),
        ];
    }
}
