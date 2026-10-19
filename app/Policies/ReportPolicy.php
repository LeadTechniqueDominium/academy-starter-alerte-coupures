<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Report;
use App\Models\User;

/**
 * Droits sur les signalements. Laravel trouve cette classe tout seul grâce à son nom.
 *
 * Seuls les modérateurs ont un compte : être connecté suffit. Les citoyens signalent
 * sans compte, sur des pages publiques qui n'utilisent pas cette policy.
 */
class ReportPolicy
{
    /**
     * Liste complète des signalements, avec les téléphones.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Suppression d'un signalement abusif.
     */
    public function delete(User $user, Report $report): bool
    {
        return true;
    }
}
