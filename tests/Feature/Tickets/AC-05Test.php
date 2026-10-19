<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| AC-05 · Anti-abus : 3 signalements par téléphone et par heure
|--------------------------------------------------------------------------
|
| Fiche du ticket : docs/tickets/AC-05.md
|
| Chaque critère d'acceptation est un test marqué ->todo() : Pest l'affiche
| comme « à faire » sans le lancer. Pour chaque critère :
|   1. retirez ->todo() et écrivez le corps du test : it('...', function () { ... });
|   2. lancez-le et vérifiez qu'il échoue (la fonctionnalité n'existe pas encore) ;
|   3. codez la fonctionnalité jusqu'à ce qu'il passe.
|
*/

it('refuse le 4e signalement d\'un même téléphone dans l\'heure avec un message clair')->todo();

it('indique dans combien de minutes réessayer')->todo();

it('accepte de nouveau un signalement une heure plus tard')->todo();

it('compte la limite par téléphone, espaces compris')->todo();

it('conserve les champs saisis après un refus')->todo();

it('teste la règle de validation dédiée')->todo();
