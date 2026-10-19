<x-layout title="Connexion des modérateurs">
    <div class="mx-auto max-w-md">
        <x-card class="p-6 sm:p-8">
            <h1 class="text-2xl font-semibold tracking-tight text-stone-900">Espace modérateur</h1>
            <p class="mt-1 text-sm text-stone-600">Réservé aux modérateurs. Pour signaler une coupure, aucun compte n'est nécessaire.</p>

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5" novalidate>
                @csrf

                <x-field name="email" type="email" label="Adresse e-mail" autocomplete="email" required autofocus />
                <x-field name="password" type="password" label="Mot de passe" autocomplete="current-password" required />

                <x-button class="w-full">Se connecter</x-button>
            </form>
        </x-card>

        @if (app()->environment('local'))
            <x-card class="mt-6 p-4 text-sm text-stone-600">
                <p class="font-medium text-stone-800">Compte de démonstration (mot de passe : <code>password</code>)</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    <li>Modérateur : <code>moderateur@alerte-coupures.test</code></li>
                </ul>
            </x-card>
        @endif
    </div>
</x-layout>
