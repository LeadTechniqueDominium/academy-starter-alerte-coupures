<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| AC-01 · Filtres et signalements actifs par quartier
|--------------------------------------------------------------------------
|
| Fiche du ticket : docs/tickets/AC-01.md
|
| Chaque critère d'acceptation est un test marqué ->todo() : Pest l'affiche
| comme « à faire » sans le lancer. Pour chaque critère :
|   1. retirez ->todo() et écrivez le corps du test : it('...', function () { ... });
|   2. lancez-le et vérifiez qu'il échoue (la fonctionnalité n'existe pas encore) ;
|   3. codez la fonctionnalité jusqu'à ce qu'il passe.
|
*/

it('affiche le formulaire de filtre et conserve les choix après l\'envoi')->todo();

it('filtre les signalements par type')->todo();

it('filtre les signalements par commune et combine les deux filtres')->todo();

it('ne provoque pas d\'erreur avec une valeur de filtre inconnue')->todo();

it('affiche le nombre de signalements actifs par quartier')->todo();
