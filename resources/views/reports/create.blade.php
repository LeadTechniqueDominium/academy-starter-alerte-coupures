<x-layout title="Signaler une coupure">
    <x-page-header title="Signaler une coupure" description="Votre signalement aide vos voisins à savoir où l'eau et l'électricité sont coupées." />

    <div class="max-w-xl">
        <x-form-errors />

        <x-card class="p-6">
            <form method="POST" action="{{ route('reports.store') }}" class="space-y-5" novalidate>
                @csrf

                <fieldset>
                    <legend class="block text-sm font-medium text-stone-800">Type de coupure</legend>
                    <div class="mt-2 grid grid-cols-2 gap-3">
                        @foreach ($types as $type)
                            <label class="flex cursor-pointer items-center gap-3 rounded-md border border-stone-300 bg-white px-4 py-3 text-sm has-checked:border-brand-600 has-checked:bg-brand-50 has-checked:ring-1 has-checked:ring-brand-600">
                                <input type="radio" name="type" value="{{ $type->value }}" class="size-4 accent-brand-700"
                                       @checked(old('type') === $type->value)>
                                <span class="font-medium text-stone-900">{{ $type->label() }}</span>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error name="type" />
                </fieldset>

                <x-neighborhood-select :communes="$communes" required />

                <div>
                    <label for="description" class="block text-sm font-medium text-stone-800">Description</label>
                    <textarea id="description" name="description" rows="4" maxlength="500" required
                              aria-describedby="description-aide @error('description') description-erreur @enderror"
                              @error('description') aria-invalid="true" @enderror
                              @class([
                                  'mt-1 block w-full rounded-md border bg-white px-3 py-2 text-sm shadow-xs',
                                  'focus:border-brand-600 focus:outline-2 focus:outline-offset-0 focus:outline-brand-600/30',
                                  'border-red-600' => $errors->has('description'),
                                  'border-stone-300' => ! $errors->has('description'),
                              ])>{{ old('description') }}</textarea>
                    <p id="description-aide" class="mt-1 text-xs text-stone-500">Depuis quand ? Toute la rue ou seulement votre maison ? 500 caractères au plus.</p>
                    <x-input-error name="description" id="description-erreur" />
                </div>

                <x-field name="phone" type="tel" label="Téléphone" autocomplete="tel"
                         hint="10 chiffres. Il n'est jamais affiché publiquement." required />

                <x-button>Envoyer le signalement</x-button>
            </form>
        </x-card>
    </div>
</x-layout>
