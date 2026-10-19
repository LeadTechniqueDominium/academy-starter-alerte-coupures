{{--
    Liste déroulante des quartiers, regroupés par commune (<optgroup>), avec libellé et message d'erreur.
    <x-neighborhood-select :communes="$communes" />
    $communes : collection de Commune avec leurs quartiers chargés (with('neighborhoods')).
--}}
@props(['communes', 'name' => 'neighborhood_id', 'label' => 'Quartier', 'selected' => null])

@php
    $hasError = $errors->has($name);
    $current = (string) old($name, $selected);
@endphp

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-stone-800">{{ $label }}</label>
    <select id="{{ $name }}" name="{{ $name }}"
            @if ($hasError) aria-invalid="true" aria-describedby="{{ $name }}-erreur" @endif
            {{ $attributes->class([
                'mt-1 block w-full rounded-md border bg-white px-3 py-2 text-sm shadow-xs',
                'focus:border-brand-600 focus:outline-2 focus:outline-offset-0 focus:outline-brand-600/30',
                'border-red-600' => $hasError,
                'border-stone-300' => ! $hasError,
            ]) }}>
        <option value="">Choisissez votre quartier</option>
        @foreach ($communes as $commune)
            <optgroup label="{{ $commune->name }}">
                @foreach ($commune->neighborhoods as $neighborhood)
                    <option value="{{ $neighborhood->id }}" @selected($current === (string) $neighborhood->id)>{{ $neighborhood->name }}</option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
    <x-input-error :name="$name" :id="$name.'-erreur'" />
</div>
