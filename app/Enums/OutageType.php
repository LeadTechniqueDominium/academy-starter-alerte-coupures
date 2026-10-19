<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Type de coupure signalée.
 */
enum OutageType: string
{
    case Water = 'water';
    case Electricity = 'electricity';

    public function label(): string
    {
        return match ($this) {
            self::Water => 'Eau',
            self::Electricity => 'Électricité',
        };
    }

    /**
     * Couleur du badge affiché dans l'interface (voir le composant <x-badge>).
     */
    public function color(): string
    {
        return match ($this) {
            self::Water => 'blue',
            self::Electricity => 'amber',
        };
    }
}
