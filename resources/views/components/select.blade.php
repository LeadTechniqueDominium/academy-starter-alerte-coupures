{{--
    Liste déroulante avec libellé et message d'erreur.
    <x-select name="member_id" label="Membre" :options="[1 => 'Aya Traoré']" :selected="1" placeholder="Choisissez" />
--}}
@props(['name', 'label', 'options' => [], 'selected' => null, 'placeholder' => null, 'hint' => null])

@php
    $id = $attributes->get('id', $name);
    $hasError = $errors->has($name);
    $current = (string) old($name, $selected);
    $describedBy = collect([$hint ? $id.'-aide' : null, $hasError ? $id.'-erreur' : null])->filter()->implode(' ');
@endphp

<div>
    <label for="{{ $id }}" class="block text-sm font-medium text-stone-800">{{ $label }}</label>
    <select id="{{ $id }}" name="{{ $name }}"
            @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
            @if ($hasError) aria-invalid="true" @endif
            {{ $attributes->except('id')->class([
                'mt-1 block w-full rounded-md border bg-white px-3 py-2 text-sm shadow-xs',
                'focus:border-brand-600 focus:outline-2 focus:outline-offset-0 focus:outline-brand-600/30',
                'border-red-600' => $hasError,
                'border-stone-300' => ! $hasError,
            ]) }}>
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach ($options as $value => $optionLabel)
            <option value="{{ $value }}" @selected($current === (string) $value)>{{ $optionLabel }}</option>
        @endforeach
    </select>
    @if ($hint)
        <p id="{{ $id }}-aide" class="mt-1 text-xs text-stone-500">{{ $hint }}</p>
    @endif
    <x-input-error :name="$name" :id="$id.'-erreur'" />
</div>
