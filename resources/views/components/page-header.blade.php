{{-- En-tête de page : titre, description facultative et boutons d'action (slot « actions »). --}}
@props(['title', 'description' => null])

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <h1 class="text-2xl font-semibold tracking-tight text-stone-900">{{ $title }}</h1>
        @if ($description)
            <p class="mt-1 text-sm text-stone-600">{{ $description }}</p>
        @endif
    </div>

    @isset($actions)
        <div class="flex flex-wrap gap-2">{{ $actions }}</div>
    @endisset
</div>
