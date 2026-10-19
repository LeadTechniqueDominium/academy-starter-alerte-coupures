<x-layout title="Recevoir les alertes">
    <x-page-header title="Recevoir les alertes de votre quartier" description="Inscrivez votre téléphone pour être prévenu des coupures dans votre quartier." />

    <div class="max-w-xl">
        <x-form-errors />

        <x-card class="p-6">
            <form method="POST" action="{{ route('subscribers.store') }}" class="space-y-5" novalidate>
                @csrf

                <x-field name="phone" type="tel" label="Téléphone" autocomplete="tel"
                         hint="10 chiffres, par exemple 07 08 12 34 56." required />

                <x-neighborhood-select :communes="$communes" required />

                <x-button>M'abonner</x-button>
            </form>
        </x-card>

        <p class="mt-4 text-xs text-stone-500">
            Projet de formation : aucun SMS n'est réellement envoyé.
        </p>
    </div>
</x-layout>
