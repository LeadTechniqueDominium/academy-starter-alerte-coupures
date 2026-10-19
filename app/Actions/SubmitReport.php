<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\IncidentStatus;
use App\Enums\OutageType;
use App\Models\Neighborhood;
use App\Models\Report;
use Illuminate\Support\Facades\DB;

/**
 * Enregistre le signalement d'un citoyen.
 *
 * Une « Action » est une classe qui fait une seule chose métier. Le contrôleur l'appelle après
 * la validation du formulaire.
 *
 * Pour l'instant, chaque signalement ouvre sa propre coupure (incident). Le regroupement des
 * signalements d'une même coupure fait l'objet du ticket AC-03.
 */
final class SubmitReport
{
    public function handle(OutageType $type, Neighborhood $neighborhood, string $description, string $phone): Report
    {
        // Transaction : la coupure et le signalement sont enregistrés ensemble, ou pas du tout.
        return DB::transaction(function () use ($type, $neighborhood, $description, $phone): Report {
            $incident = $neighborhood->incidents()->create([
                'type' => $type,
                'status' => IncidentStatus::Active,
                'started_at' => now(),
            ]);

            return $incident->reports()->create([
                'description' => $description,
                'phone' => $phone,
            ]);
        });
    }
}
