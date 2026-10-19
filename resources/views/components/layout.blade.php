{{--
    Mise en page commune à toutes les pages : <x-layout title="Titre de la page"> ... </x-layout>
--}}
@props(['title' => null])

@php
    // Liens du menu principal, selon le visiteur. « active » indique les routes du lien mis en évidence.
    $navigation = [
        ['label' => 'Signalements récents', 'route' => 'reports.index', 'active' => 'reports.index'],
        ['label' => 'Signaler une coupure', 'route' => 'reports.create', 'active' => 'reports.create'],
        ['label' => 'Alertes SMS', 'route' => 'subscribers.create', 'active' => 'subscribers.*'],
        auth()->check()
            ? ['label' => 'Modération', 'route' => 'moderation.reports.index', 'active' => 'moderation.*']
            : ['label' => 'Espace modérateur', 'route' => 'login', 'active' => 'login'],
    ];
@endphp

<!DOCTYPE html>
<html lang="fr" class="h-full bg-stone-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ? $title.' · ' : '' }}{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col text-stone-800 antialiased">
    <a href="#contenu" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-md focus:bg-white focus:px-4 focus:py-2 focus:shadow">
        Aller au contenu
    </a>

    <header x-data="{ open: false }" class="border-b border-stone-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 sm:px-6">
            <div class="flex h-16 items-center justify-between gap-4">
                <a href="{{ route('reports.index') }}" class="flex items-center gap-2 rounded-md font-semibold text-brand-800 focus-visible:outline-2 focus-visible:outline-brand-700">
                    <x-logo class="size-8" />
                    <span>{{ config('app.name') }}</span>
                </a>

                <nav aria-label="Navigation principale" class="hidden items-center gap-1 md:flex">
                    @foreach ($navigation as $link)
                        <a href="{{ route($link['route']) }}"
                           @if (request()->routeIs($link['active'])) aria-current="page" @endif
                           @class([
                               'rounded-md px-3 py-2 text-sm font-medium focus-visible:outline-2 focus-visible:outline-brand-700',
                               'bg-brand-50 text-brand-800' => request()->routeIs($link['active']),
                               'text-stone-600 hover:bg-stone-100 hover:text-stone-900' => ! request()->routeIs($link['active']),
                           ])>
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </nav>

                @auth
                    <div class="hidden items-center gap-3 md:flex">
                        <p class="text-right text-sm leading-tight">
                            <span class="block font-medium text-stone-900">{{ auth()->user()->name }}</span>
                            <span class="block text-stone-500">Modérateur</span>
                        </p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-button variant="secondary">Se déconnecter</x-button>
                        </form>
                    </div>
                @endauth

                <button type="button"
                        class="inline-flex items-center justify-center rounded-md p-2 text-stone-600 hover:bg-stone-100 focus-visible:outline-2 focus-visible:outline-brand-700 md:hidden"
                        aria-controls="menu-mobile"
                        :aria-expanded="open.toString()"
                        aria-expanded="false"
                        @click="open = ! open">
                    <span class="sr-only">Ouvrir ou fermer le menu</span>
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path x-show="! open" stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div id="menu-mobile" x-show="open" x-cloak class="border-t border-stone-200 py-3 md:hidden">
                <nav aria-label="Navigation principale (mobile)" class="flex flex-col gap-1">
                    @foreach ($navigation as $link)
                        <a href="{{ route($link['route']) }}"
                           @if (request()->routeIs($link['active'])) aria-current="page" @endif
                           @class([
                               'rounded-md px-3 py-2 text-base font-medium',
                               'bg-brand-50 text-brand-800' => request()->routeIs($link['active']),
                               'text-stone-700 hover:bg-stone-100' => ! request()->routeIs($link['active']),
                           ])>
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </nav>
                @auth
                    <div class="mt-3 flex items-center justify-between gap-3 border-t border-stone-200 pt-3">
                        <p class="text-sm leading-tight">
                            <span class="block font-medium text-stone-900">{{ auth()->user()->name }}</span>
                            <span class="block text-stone-500">Modérateur</span>
                        </p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-button variant="secondary">Se déconnecter</x-button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <main id="contenu" class="mx-auto w-full max-w-6xl flex-1 px-4 py-8 sm:px-6">
        <x-flash />

        {{ $slot }}
    </main>

    <footer class="border-t border-stone-200 bg-white">
        <p class="mx-auto max-w-6xl px-4 py-4 text-xs text-stone-500 sm:px-6">
            Projet de formation Dominium Academy · données entièrement fictives, aucun lien avec les compagnies d'eau et d'électricité
        </p>
    </footer>
</body>
</html>
