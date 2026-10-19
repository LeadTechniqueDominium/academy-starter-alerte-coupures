<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| AC-08 · Export CSV des coupures pour le modérateur
|--------------------------------------------------------------------------
|
| Fiche du ticket : docs/tickets/AC-08.md
|
| Chaque critère d'acceptation est un test marqué ->todo() : Pest l'affiche
| comme « à faire » sans le lancer. Pour chaque critère :
|   1. retirez ->todo() et écrivez le corps du test : it('...', function () { ... });
|   2. lancez-le et vérifiez qu'il échoue (la fonctionnalité n'existe pas encore) ;
|   3. codez la fonctionnalité jusqu'à ce qu'il passe.
|
*/

it('affiche le formulaire d\'export dans l\'espace de modération')->todo();

it('télécharge un fichier CSV nommé avec la période')->todo();

it('produit les colonnes attendues avec point-virgule et BOM UTF-8')->todo();

it('n\'exporte que les coupures commencées pendant la période')->todo();

it('valide les dates de la période')->todo();

it('réserve l\'export aux modérateurs')->todo();
