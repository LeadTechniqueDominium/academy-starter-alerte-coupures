{{-- Résumé affiché en haut d'un formulaire quand la validation échoue. --}}
@if ($errors->any())
    <div role="alert" class="mb-6 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
        <p class="font-medium">Le formulaire contient des erreurs. Corrigez les champs signalés ci-dessous.</p>
    </div>
@endif
