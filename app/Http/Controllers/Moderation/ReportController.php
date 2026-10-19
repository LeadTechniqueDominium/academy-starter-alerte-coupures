<?php

declare(strict_types=1);

namespace App\Http\Controllers\Moderation;

use App\Actions\DeleteReport;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 * Espace du modérateur : liste complète des signalements et suppression des abus.
 */
class ReportController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Report::class);

        return view('moderation.reports.index', [
            'reports' => Report::query()
                ->with('incident.neighborhood.commune')
                ->latest()
                ->latest('id')
                ->paginate(20),
        ]);
    }

    public function destroy(Report $report, DeleteReport $deleteReport): RedirectResponse
    {
        Gate::authorize('delete', $report);

        $deleteReport->handle($report);

        return back()->with('success', 'Le signalement a été supprimé.');
    }
}
