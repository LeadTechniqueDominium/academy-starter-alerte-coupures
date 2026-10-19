<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Report;
use Illuminate\Support\Facades\DB;

/**
 * Supprime un signalement abusif. Une coupure qui n'a plus aucun signalement est supprimée aussi.
 */
final class DeleteReport
{
    public function handle(Report $report): void
    {
        DB::transaction(function () use ($report): void {
            $incident = $report->incident()->firstOrFail();

            $report->delete();

            if (! $incident->reports()->exists()) {
                $incident->delete();
            }
        });
    }
}
