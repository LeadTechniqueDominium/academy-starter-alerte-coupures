{{-- Message d'erreur de validation d'un champ. --}}
@props(['name', 'id' => null])

@error($name)
    <p id="{{ $id ?? $name.'-erreur' }}" class="mt-1 text-sm text-red-700">{{ $message }}</p>
@enderror
