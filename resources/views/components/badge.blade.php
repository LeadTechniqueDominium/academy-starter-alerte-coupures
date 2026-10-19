{{-- Petite étiquette colorée : <x-badge color="green">Payé</x-badge> --}}
@props(['color' => 'stone'])

<span {{ $attributes->class([
    'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset',
    match ($color) {
        'green' => 'bg-green-50 text-green-800 ring-green-600/20',
        'red' => 'bg-red-50 text-red-800 ring-red-600/20',
        'amber' => 'bg-amber-50 text-amber-900 ring-amber-600/20',
        'blue' => 'bg-sky-50 text-sky-800 ring-sky-600/20',
        default => 'bg-stone-100 text-stone-700 ring-stone-500/20',
    },
]) }}>{{ $slot }}</span>
