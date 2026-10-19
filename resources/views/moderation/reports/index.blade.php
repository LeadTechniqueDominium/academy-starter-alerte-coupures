<x-layout title="Modération">
    <x-page-header title="Modération des signalements" :description="'Tous les signalements, du plus récent au plus ancien · '.$reports->total().' au total.'" />

    @if ($reports->isEmpty())
        <x-card class="p-6 text-sm text-stone-600">Aucun signalement.</x-card>
    @else
        <x-card class="overflow-x-auto">
            <table class="min-w-full divide-y divide-stone-200 text-sm">
                <caption class="sr-only">Liste complète des signalements</caption>
                <thead class="bg-stone-50 text-left text-stone-600">
                    <tr>
                        <th scope="col" class="px-4 py-3 font-medium">Date</th>
                        <th scope="col" class="px-4 py-3 font-medium">Type</th>
                        <th scope="col" class="px-4 py-3 font-medium">Commune · quartier</th>
                        <th scope="col" class="px-4 py-3 font-medium">Description</th>
                        <th scope="col" class="px-4 py-3 font-medium">Téléphone</th>
                        <th scope="col" class="px-4 py-3 font-medium">Statut</th>
                        <th scope="col" class="px-4 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach ($reports as $report)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap tabular-nums">{{ $report->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3"><x-badge :color="$report->incident->type->color()">{{ $report->incident->type->label() }}</x-badge></td>
                            <td class="px-4 py-3">
                                {{ $report->incident->neighborhood->commune->name }} · {{ $report->incident->neighborhood->name }}
                            </td>
                            <td class="max-w-xs px-4 py-3 text-stone-700">{{ $report->description }}</td>
                            <td class="px-4 py-3 whitespace-nowrap tabular-nums">{{ $report->phone }}</td>
                            <td class="px-4 py-3">{{ $report->incident->status->label() }}</td>
                            <td class="px-4 py-3 text-right">
                                <form method="POST" action="{{ route('moderation.reports.destroy', $report) }}"
                                      x-data
                                      @submit="if (! confirm('Supprimer ce signalement abusif ?')) $event.preventDefault()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-700 underline-offset-2 hover:underline focus-visible:outline-2 focus-visible:outline-red-700">
                                        Supprimer<span class="sr-only"> le signalement du {{ $report->created_at->format('d/m/Y H:i') }}</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-card>

        <div class="mt-6">
            {{ $reports->links() }}
        </div>
    @endif
</x-layout>
