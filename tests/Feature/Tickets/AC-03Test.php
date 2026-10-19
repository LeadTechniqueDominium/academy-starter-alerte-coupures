<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| AC-03 · Regroupement des signalements en une seule coupure
|--------------------------------------------------------------------------
|
| Fiche du ticket : docs/tickets/AC-03.md
|
| Chaque critère d'acceptation est un test marqué ->todo() : Pest l'affiche
| comme « à faire » sans le lancer. Pour chaque critère :
|   1. retirez ->todo() et écrivez le corps du test : it('...', function () { ... });
|   2. lancez-le et vérifiez qu'il échoue (la fonctionnalité n'existe pas encore) ;
|   3. codez la fonctionnalité jusqu'à ce qu'il passe.
|
*/

it('rattache un signalement à la coupure en cours du même type et du même quartier')->todo();

it('crée une nouvelle coupure pour un autre type ou un autre quartier')->todo();

it('ne rattache jamais un signalement à une coupure résolue')->todo();

it('crée une nouvelle coupure au-delà de 2 heures')->todo();

it('affiche une carte par coupure avec le nombre de signalements')->todo();

it('applique la règle de regroupement dans l\'action SubmitReport')->todo();
