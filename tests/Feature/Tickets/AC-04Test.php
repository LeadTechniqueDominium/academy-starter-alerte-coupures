<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| AC-04 · « Moi aussi » et coupures confirmées
|--------------------------------------------------------------------------
|
| Fiche du ticket : docs/tickets/AC-04.md
|
| Chaque critère d'acceptation est un test marqué ->todo() : Pest l'affiche
| comme « à faire » sans le lancer. Pour chaque critère :
|   1. retirez ->todo() et écrivez le corps du test : it('...', function () { ... });
|   2. lancez-le et vérifiez qu'il échoue (la fonctionnalité n'existe pas encore) ;
|   3. codez la fonctionnalité jusqu'à ce qu'il passe.
|
*/

it('ajoute un signalement « Moi aussi » à une coupure en cours')->todo();

it('refuse un second « Moi aussi » du même téléphone pour la même coupure')->todo();

it('confirme une coupure à partir de 3 téléphones différents')->todo();

it('affiche le badge Confirmée sur la liste publique et en modération')->todo();

it('refuse un « Moi aussi » sur une coupure résolue')->todo();

it('teste la règle de confirmation dans une classe dédiée')->todo();
