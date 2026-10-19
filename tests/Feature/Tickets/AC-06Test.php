<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| AC-06 · Notifications SMS des abonnés via la file d'attente
|--------------------------------------------------------------------------
|
| Fiche du ticket : docs/tickets/AC-06.md
|
| Chaque critère d'acceptation est un test marqué ->todo() : Pest l'affiche
| comme « à faire » sans le lancer. Pour chaque critère :
|   1. retirez ->todo() et écrivez le corps du test : it('...', function () { ... });
|   2. lancez-le et vérifiez qu'il échoue (la fonctionnalité n'existe pas encore) ;
|   3. codez la fonctionnalité jusqu'à ce qu'il passe.
|
*/

it('déclenche l\'événement IncidentConfirmed une seule fois à la confirmation')->todo();

it('met en file d\'attente l\'envoi des SMS aux abonnés du quartier')->todo();

it('enregistre les SMS simulés via l\'interface SmsSender')->todo();

it('n\'envoie jamais deux SMS au même abonné pour la même coupure')->todo();

it('ne prévient pas les abonnés des autres quartiers')->todo();

it('teste la mise en file et l\'exécution du job')->todo();
