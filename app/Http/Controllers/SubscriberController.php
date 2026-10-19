<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriberRequest;
use App\Models\Commune;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Inscription publique aux alertes d'un quartier (sans compte).
 */
class SubscriberController extends Controller
{
    public function create(): View
    {
        return view('subscribers.create', [
            'communes' => Commune::query()->with('neighborhoods')->orderBy('name')->get(),
        ]);
    }

    public function store(StoreSubscriberRequest $request): RedirectResponse
    {
        Subscriber::create($request->validated());

        return redirect()->route('subscribers.create')->with('success', 'Votre abonnement est enregistré. Vous serez prévenu des coupures dans ce quartier.');
    }
}
