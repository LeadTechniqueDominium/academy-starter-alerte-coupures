<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\SubmitReport;
use App\Enums\OutageType;
use App\Http\Requests\StoreReportRequest;
use App\Models\Commune;
use App\Models\Neighborhood;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Pages publiques : liste des signalements récents et formulaire de signalement.
 */
class ReportController extends Controller
{
    /**
     * Les signalements sont considérés comme « récents » pendant 48 heures.
     */
    private const RECENT_HOURS = 48;

    public function index(): View
    {
        $reports = Report::query()
            ->with('incident.neighborhood.commune')
            ->where('created_at', '>=', now()->subHours(self::RECENT_HOURS))
            ->latest()
            ->get();

        return view('reports.index', [
            'recentHours' => self::RECENT_HOURS,
            // Regroupe les signalements par nom de commune, communes dans l'ordre alphabétique.
            'reportsByCommune' => $reports
                ->groupBy(fn (Report $report) => $report->incident->neighborhood->commune->name)
                ->sortKeys(),
        ]);
    }

    public function create(): View
    {
        return view('reports.create', [
            'communes' => Commune::query()->with('neighborhoods')->orderBy('name')->get(),
            'types' => OutageType::cases(),
        ]);
    }

    public function store(StoreReportRequest $request, SubmitReport $submitReport): RedirectResponse
    {
        $submitReport->handle(
            type: $request->enum('type', OutageType::class),
            neighborhood: Neighborhood::query()->findOrFail($request->integer('neighborhood_id')),
            description: $request->string('description')->trim()->toString(),
            phone: $request->string('phone')->toString(),
        );

        return redirect()->route('reports.index')->with('success', 'Merci, votre signalement a été enregistré.');
    }
}
