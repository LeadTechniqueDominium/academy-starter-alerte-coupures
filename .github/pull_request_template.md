## Ticket concerné

<!-- Exemple : AC-05 · Anti-abus (docs/tickets/AC-05.md) -->

## Ce qui a été fait

<!-- Décrivez les changements en quelques points : fichiers créés ou modifiés, choix techniques. -->

-

## Comment tester

<!-- Les étapes pour vérifier à la main, depuis une base neuve (php artisan migrate:fresh --seed). -->

1.
2.

## Captures d'écran

<!-- Avant / après si l'interface change. Sinon, écrivez « Sans objet ». -->

## Checklist

- [ ] Les critères d'acceptation du ticket sont tous couverts par des tests (plus aucun `->todo()` dans `tests/Feature/Tickets/`).
- [ ] `php artisan test` passe en local.
- [ ] `./vendor/bin/pint --test` ne signale aucune erreur.
- [ ] Aucun secret, aucun fichier `.env`, aucune base de données dans les commits.
- [ ] La branche s'appelle `ticket/<CODE>` et les messages de commit suivent la convention du README.
