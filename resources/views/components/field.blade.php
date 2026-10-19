{{--
    Champ de formulaire avec son libellé, une aide facultative et le message d'erreur.
    <x-field name="phone" label="Téléphone" hint="10 chiffres" :value="$member->phone" required />
--}}
@props(['name', 'label', 'type' => 'text', 'value' => null, 'hint' => null])

@php
    $id = $attributes->get('id', $name);
    $hasError = $errors->has($name);
    $describedBy = collect([$hint ? $id.'-aide' : null, $hasError ? $id.'-erreur' : null])->filter()->implode(' ');
@endphp

<div>
    <label for="{{ $id }}" class="block text-sm font-medium text-stone-800">{{ $label }}</label>
    <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}"
           value="{{ $type === 'password' ? '' : old($name, $value) }}"
           @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
           @if ($hasError) aria-invalid="true" @endif
           {{ $attributes->except('id')->class([
               'mt-1 block w-full rounded-md border bg-white px-3 py-2 text-sm shadow-xs',
               'focus:border-brand-600 focus:outline-2 focus:outline-offset-0 focus:outline-brand-600/30',
               'border-red-600' => $hasError,
               'border-stone-300' => ! $hasError,
           ]) }}>
    @if ($hint)
        <p id="{{ $id }}-aide" class="mt-1 text-xs text-stone-500">{{ $hint }}</p>
    @endif
    <x-input-error :name="$name" :id="$id.'-erreur'" />
</div>
