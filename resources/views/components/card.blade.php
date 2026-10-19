{{-- Encadré blanc : <x-card>...</x-card>. « relative » garde les textes sr-only à l'intérieur (tableaux défilants). --}}
<div {{ $attributes->class('relative rounded-lg border border-stone-200 bg-white shadow-xs') }}>
    {{ $slot }}
</div>
