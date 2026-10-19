<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Statut d'une coupure (incident).
 */
enum IncidentStatus: string
{
    case Active = 'active';
    case Resolved = 'resolved';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'En cours',
            self::Resolved => 'Résolue',
        };
    }
}
