<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| AC-02 · Coupure résolue et durée de la coupure
|--------------------------------------------------------------------------
|
| Fiche du ticket : docs/tickets/AC-02.md
|
| Chaque critère d'acceptation est un test marqué ->todo() : Pest l'affiche
| comme « à faire » sans le lancer. Pour chaque critère :
|   1. retirez ->todo() et écrivez le corps du test : it('...', function () { ... });
|   2. lancez-le et vérifiez qu'il échoue (la fonctionnalité n'existe pas encore) ;
|   3. codez la fonctionnalité jusqu'à ce qu'il passe.
|
*/

it('propose au modérateur de marquer une coupure en cours comme résolue')->todo();

it('refuse une heure de fin antérieure au début ou dans le futur')->todo();

it('enregistre le statut résolue et l\'heure de fin')->todo();

it('affiche la durée de la coupure au format « 3 h 20 min »')->todo();

it('interdit de résoudre deux fois une coupure et réserve l\'action aux modérateurs')->todo();

it('calcule et formate la durée à un seul endroit')->todo();
