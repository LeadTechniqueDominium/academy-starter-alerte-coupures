{{--
    Bouton ou lien qui ressemble à un bouton.
    <x-button>Enregistrer</x-button>
    <x-button href="/membres" variant="secondary">Annuler</x-button>
--}}
@props(['href' => null, 'variant' => 'primary', 'type' => 'submit'])

@php
    $classes = [
        'inline-flex items-center justify-center gap-2 rounded-md px-4 py-2 text-sm font-semibold shadow-xs',
        'focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700 disabled:opacity-50',
        match ($variant) {
            'secondary' => 'bg-white text-stone-700 ring-1 ring-stone-300 ring-inset hover:bg-stone-50',
            'danger' => 'bg-red-700 text-white hover:bg-red-800',
            default => 'bg-brand-700 text-white hover:bg-brand-800',
        },
    ];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>{{ $slot }}</button>
@endif
