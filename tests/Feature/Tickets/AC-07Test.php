<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| AC-07 · Historique d'un quartier sur 30 jours
|--------------------------------------------------------------------------
|
| Fiche du ticket : docs/tickets/AC-07.md
|
| Chaque critère d'acceptation est un test marqué ->todo() : Pest l'affiche
| comme « à faire » sans le lancer. Pour chaque critère :
|   1. retirez ->todo() et écrivez le corps du test : it('...', function () { ... });
|   2. lancez-le et vérifiez qu'il échoue (la fonctionnalité n'existe pas encore) ;
|   3. codez la fonctionnalité jusqu'à ce qu'il passe.
|
*/

it('affiche la page d\'historique d\'un quartier et renvoie 404 pour un quartier inconnu')->todo();

it('compte les coupures des 30 derniers jours par type')->todo();

it('calcule la durée cumulée par type, coupures en cours comprises')->todo();

it('ignore les coupures de plus de 30 jours')->todo();

it('liste les coupures de la période de la plus récente à la plus ancienne')->todo();

it('calcule l\'historique dans une classe dédiée testée avec une date figée')->todo();
