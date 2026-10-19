<x-layout title="Signalements récents">
    <x-page-header title="Coupures signalées à Abidjan"
                   :description="'Signalements des '.$recentHours.' dernières heures, commune par commune.'">
        <x-slot:actions>
            <x-button :href="route('reports.create')">Signaler une coupure</x-button>
            <x-button :href="route('subscribers.create')" variant="secondary">Recevoir les alertes</x-button>
        </x-slot:actions>
    </x-page-header>

    @forelse ($reportsByCommune as $commune => $reports)
        <section aria-labelledby="commune-{{ $loop->index }}" class="mb-8">
            <h2 id="commune-{{ $loop->index }}" class="mb-3 text-lg font-semibold text-stone-900">
                {{ $commune }}
                <span class="text-sm font-normal text-stone-500">· {{ $reports->count() }} signalement(s)</span>
            </h2>

            <ul class="grid gap-3 md:grid-cols-2">
                @foreach ($reports as $report)
                    <li>
                        <x-card class="h-full p-4">
                            <div class="flex flex-wrap items-center gap-2">
                                <x-badge :color="$report->incident->type->color()">{{ $report->incident->type->label() }}</x-badge>
                                @if ($report->incident->status === App\Enums\IncidentStatus::Resolved)
                                    <x-badge color="green">{{ $report->incident->status->label() }}</x-badge>
                                @endif
                                <span class="font-medium text-stone-900">{{ $report->incident->neighborhood->name }}</span>
                            </div>
                            <p class="mt-2 text-sm text-stone-700">{{ $report->description }}</p>
                            <p class="mt-2 text-xs text-stone-500">
                                Signalé <time datetime="{{ $report->created_at->toIso8601String() }}">{{ $report->created_at->diffForHumans() }}</time>
                            </p>
                        </x-card>
                    </li>
                @endforeach
            </ul>
        </section>
    @empty
        <x-card class="p-6 text-sm text-stone-600">
            Aucune coupure signalée ces {{ $recentHours }} dernières heures.
        </x-card>
    @endforelse
</x-layout>
