# Alerte Coupures

> Savoir en temps réel où l'eau et l'électricité sont coupées, quartier par quartier.

Les habitants d'Abidjan signalent les coupures d'eau et d'électricité de leur quartier ; tout le monde voit
les signalements récents, commune par commune. Un modérateur supprime les signalements abusifs.

Ce dépôt est un **projet de départ du module 8 de Dominium Academy** (Développement et intégration). Vous en
créez votre propre copie, vous réalisez **un ticket** avec ses tests sur une branche, puis vous ouvrez une
pull request dans votre copie. Les modules 9 à 12 (tests, déploiement, recette, maintenance) s'appuient
ensuite sur ce même projet.

Projet fictif : aucune donnée réelle, aucun secret, aucun lien avec les compagnies d'eau et d'électricité.

## Sommaire

- [Ce que fait déjà l'application](#ce-que-fait-déjà-lapplication)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Comptes de démonstration](#comptes-de-démonstration)
- [Lancer les tests et vérifier le style](#lancer-les-tests-et-vérifier-le-style)
- [Structure du projet](#structure-du-projet)
- [Les tickets](#les-tickets)
- [Travailler sur un ticket](#travailler-sur-un-ticket)
- [Conventions : branches, commits, pull requests](#conventions--branches-commits-pull-requests)

## Ce que fait déjà l'application

Trois rôles :

- **Citoyen** (sans compte) : signale une coupure et consulte les signalements récents.
- **Abonné** (sans compte, un téléphone et un quartier) : s'inscrit pour être prévenu des coupures de son
  quartier (l'envoi des alertes fait l'objet du ticket AC-06).
- **Modérateur** (avec compte) : voit la liste complète des signalements et supprime les abus.

Fonctionnalités en place :

- les 13 communes du District d'Abidjan et une soixantaine de quartiers (créés par le seeder) ;
- le signalement public : type (eau ou électricité), quartier, description, téléphone ;
- la liste des signalements des dernières 48 heures, regroupés par commune (les téléphones ne sont jamais
  affichés publiquement) ;
- l'inscription d'un abonné : téléphone et quartier ;
- l'espace modérateur : liste complète et paginée des signalements, suppression d'un signalement abusif ;
- des données de démonstration : signalements récents dans toutes les communes et un historique de coupures
  résolues sur 40 jours.

Vocabulaire du code : un **signalement** (`Report`) est envoyé par un citoyen ; il est rattaché à une
**coupure** (`Incident`) qui a un type, un quartier, un début et éventuellement une fin. Pour l'instant,
chaque signalement crée sa propre coupure : le regroupement est le ticket AC-03.

Ce qui manque (filtres, coupures résolues, regroupement, votes, alertes SMS...) fait l'objet des
[tickets](#les-tickets).

## Prérequis

| Outil | Version | Vérifier |
| --- | --- | --- |
| PHP | 8.3 ou plus récent, avec les extensions `pdo_sqlite`, `sqlite3`, `mbstring` | `php -v` et `php -m` |
| Composer | 2.x | `composer --version` |
| Node.js et npm | Node 22 LTS (ou 20.19 et plus) | `node -v` |
| Git | récent | `git --version` |

Aucune base de données à installer : l'application utilise **SQLite**, un simple fichier
(`database/database.sqlite`).

## Installation

### En une commande

Après avoir cloné votre copie du dépôt (voir [Travailler sur un ticket](#travailler-sur-un-ticket)) :

```bash
cd academy-starter-alerte-coupures
composer setup
php artisan serve
```

`composer setup` enchaîne toutes les étapes ci-dessous. Attention : il **repart d'une base neuve** à chaque
fois (`migrate:fresh`).

### Pas à pas

1. Installez les dépendances PHP :

   ```bash
   composer install
   ```

2. Créez votre fichier de configuration local à partir du modèle, puis générez la clé de l'application :

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Sous Windows (PowerShell), remplacez `cp` par `Copy-Item .env.example .env`.

3. Créez le fichier de la base SQLite, puis créez les tables et les données de démonstration :

   ```bash
   php -r "touch('database/database.sqlite');"
   php artisan migrate --seed
   ```

4. Installez les dépendances front (Tailwind CSS, Alpine.js) et compilez les fichiers CSS et JavaScript :

   ```bash
   npm install
   npm run build
   ```

5. Lancez le serveur de développement :

   ```bash
   php artisan serve
   ```

   Ouvrez <http://localhost:8000> : c'est la liste publique des signalements. L'espace modérateur est sur
   <http://localhost:8000/connexion>.

Pendant que vous modifiez les vues, lancez `npm run dev` dans un deuxième terminal : les styles sont recompilés
et la page se recharge toute seule.

Les signalements de démonstration sont datés par rapport au moment où vous lancez le seeder. Deux jours plus
tard, ils ne sont plus « récents » : relancez `php artisan migrate:fresh --seed`.

### Utiliser MySQL (facultatif)

L'application fonctionne aussi avec MySQL 8. Créez une base vide `alerte_coupures`, puis dans `.env`
commentez `DB_CONNECTION=sqlite` et renseignez le bloc MySQL (`DB_CONNECTION=mysql`, `DB_HOST`,
`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`). Lancez ensuite `php artisan migrate:fresh --seed`. Les tests,
eux, utilisent toujours une base SQLite en mémoire (voir `phpunit.xml`).

## Comptes de démonstration

Seuls les modérateurs ont un compte. Mot de passe : **`password`**.

| Rôle | Nom | Adresse e-mail |
| --- | --- | --- |
| Modérateur | Koffi Adou | `moderateur@alerte-coupures.test` |

Les citoyens et les abonnés n'ont pas de compte. Abonnés de démonstration : trois téléphones à Angré
(Cocody), deux à Niangon (Yopougon), un à PK 18 (Abobo), un à Remblais (Koumassi), un à Riviera 2 (Cocody).

## Lancer les tests et vérifier le style

```bash
php artisan test          # lance tous les tests Pest
./vendor/bin/pint --test  # vérifie le style du code sans rien modifier
./vendor/bin/pint         # corrige automatiquement le style
```

Le résultat attendu sur un dépôt neuf ressemble à ceci :

```text
Tests:    47 todos, 33 passed (115 assertions)
```

Les **todos** sont les critères d'acceptation des tickets, écrits sous forme de tests à compléter
(`tests/Feature/Tickets/`). Pest les affiche sans les lancer. Votre travail consiste à transformer ceux de
votre ticket en vrais tests qui passent.

Les mêmes vérifications tournent automatiquement sur GitHub à chaque push et à chaque pull request
(`.github/workflows/tests.yml`, onglet **Actions** de votre dépôt).

## Structure du projet

Structure Laravel standard. Les fichiers à connaître :

```text
app/
├── Actions/
│   ├── SubmitReport.php             Enregistre un signalement et sa coupure
│   └── DeleteReport.php             Supprime un signalement abusif (et sa coupure si elle est vide)
├── Enums/                           Types de coupure et statuts (avec leurs libellés)
├── Http/
│   ├── Controllers/                 Contrôleurs courts ; Moderation/ regroupe ceux du modérateur
│   └── Requests/                    Form Requests : validation des formulaires
├── Models/                          Commune, Neighborhood (quartier), Incident (coupure), Report
│                                    (signalement), Subscriber (abonné), User (modérateur)
└── Policies/ReportPolicy.php        Droits sur les signalements
database/
├── factories/                       Fabriques de données pour les tests
├── migrations/                      Structure des tables
└── seeders/
    ├── AbidjanSeeder.php            Les 13 communes et leurs quartiers
    └── DatabaseSeeder.php           Données de démonstration
docs/tickets/                        Une fiche par ticket
lang/fr/                             Messages de validation en français
resources/
├── css/app.css                      Tailwind CSS v4 et couleur principale du thème
├── js/app.js                        Alpine.js
└── views/
    ├── components/                  Composants Blade réutilisables (<x-layout>, <x-neighborhood-select>...)
    ├── reports/                     Liste publique et formulaire de signalement
    ├── subscribers/                 Inscription aux alertes
    └── moderation/                  Espace modérateur
routes/web.php                       Toutes les routes (php artisan route:list pour les voir)
tests/
├── Feature/                         Tests des pages et des formulaires
├── Feature/Tickets/                 Critères d'acceptation des tickets (tests todo)
└── Unit/                            Tests des classes isolées
```

Repères de conception :

- **Contrôleurs courts** : ils vérifient l'autorisation, délèguent le travail et renvoient une vue.
- **Form Requests** (`app/Http/Requests`) : toute donnée envoyée par un formulaire est validée côté serveur,
  même sur les pages publiques. Le téléphone est normalisé (espaces retirés) avant la validation.
- **Policies** (`app/Policies`) : les droits sont décrits à un seul endroit et vérifiés avec `Gate::authorize`.
- **Actions** : la logique métier vit hors des contrôleurs, dans une transaction quand plusieurs tables sont
  modifiées.
- **Enums** : jamais de chaîne magique (`'water'`, `'active'`) répétée dans le code.
- **Données personnelles** : le téléphone d'un citoyen n'est visible que par le modérateur.
- Les vues ne font **aucune requête** : le contrôleur prépare toutes les données. En développement, une
  relation chargée dans une boucle sans `with()` déclenche une erreur explicite (`preventLazyLoading`).
- Interface en français, vouvoiement ; dates au format `jj/mm/aaaa` ; fuseau horaire `Africa/Abidjan`.

## Les tickets

| Code | Difficulté | Ticket |
| --- | --- | --- |
| [AC-01](docs/tickets/AC-01.md) | facile | Filtrer la liste par type et par commune ; afficher le nombre de signalements actifs par quartier. |
| [AC-02](docs/tickets/AC-02.md) | facile | Le modérateur marque une coupure « résolue » avec l'heure de fin ; la durée est calculée et affichée. |
| [AC-03](docs/tickets/AC-03.md) | intermédiaire | Regroupement : un signalement du même type dans le même quartier dans les 2 heures rejoint la coupure existante. |
| [AC-04](docs/tickets/AC-04.md) | intermédiaire | Fiabilité : votes « moi aussi » ; une coupure est « confirmée » à partir de 3 téléphones différents. |
| [AC-05](docs/tickets/AC-05.md) | intermédiaire | Anti-abus : au plus 3 signalements par téléphone et par heure, avec un message clair. |
| [AC-06](docs/tickets/AC-06.md) | avancé | Notifications : SMS simulé à chaque abonné du quartier, via la file d'attente, une seule fois par abonné et par coupure. |
| [AC-07](docs/tickets/AC-07.md) | intermédiaire | Historique d'un quartier sur 30 jours : nombre de coupures et durée cumulée par type. |
| [AC-08](docs/tickets/AC-08.md) | intermédiaire | Export CSV des coupures d'une période, réservé au modérateur. |

Votre ticket est celui de votre version (1 à 8), indiquée dans Academy au module 8.

## Travailler sur un ticket

1. **Créez votre copie** : sur la page GitHub de ce dépôt, cliquez sur **Use this template** puis
   **Create a new repository**, sur votre compte GitHub.
2. **Clonez votre copie** et installez-la (voir [Installation](#installation)) :

   ```bash
   git clone https://github.com/<votre-compte>/academy-starter-alerte-coupures.git
   cd academy-starter-alerte-coupures
   composer setup
   ```

3. **Créez la branche du ticket** à partir de `main` (exemple pour AC-05) :

   ```bash
   git switch -c ticket/AC-05
   ```

4. **Lisez la fiche** `docs/tickets/AC-05.md` : contexte, critères d'acceptation, indices, fichiers concernés.
5. **Commencez par les tests** : ouvrez `tests/Feature/Tickets/AC-05Test.php`. Pour chaque critère, retirez
   `->todo()`, écrivez le test, vérifiez qu'il **échoue**, puis codez jusqu'à ce qu'il **passe**. Inspirez-vous
   des tests existants dans `tests/Feature` et `tests/Unit`.
6. **Vérifiez tout** avant chaque commit :

   ```bash
   php artisan test
   ./vendor/bin/pint
   ```

7. **Commitez par petites étapes** (voir la convention ci-dessous), puis poussez la branche :

   ```bash
   git push -u origin ticket/AC-05
   ```

8. **Ouvrez la pull request** dans votre copie : base `main`, branche `ticket/AC-05`. La description est
   pré-remplie par le modèle : complétez chaque rubrique. Attendez que la vérification automatique (onglet
   **Checks**) soit verte.
9. **Déposez le lien de la pull request** dans Academy : c'est le livrable du module 8.

Ne fusionnez pas la pull request vous-même : elle sera relue par votre formateur.

## Conventions : branches, commits, pull requests

### Branches

Une branche par ticket, nommée `ticket/<CODE>` : `ticket/AC-01`, `ticket/AC-06`... On ne travaille jamais
directement sur `main`.

### Commits

Messages en français, au présent, sous la forme `type(CODE): ce que fait le commit` :

| Type | Quand l'utiliser | Exemple |
| --- | --- | --- |
| `feat` | nouvelle fonctionnalité | `feat(AC-05): limite les signalements à 3 par heure et par téléphone` |
| `fix` | correction d'un bug | `fix(AC-05): compte le téléphone saisi avec des espaces` |
| `test` | ajout ou modification de tests | `test(AC-05): critères d'acceptation de l'anti-abus` |
| `refactor` | réorganisation sans changement de comportement | `refactor(AC-05): extrait la limite dans une règle de validation` |
| `docs` | documentation | `docs(AC-05): explique la limite dans le README` |
| `style` | mise en forme (Pint) | `style(AC-05): applique Pint` |

Règles d'or : un commit = une idée ; jamais de `.env`, de base de données (`database/database.sqlite`), de
`vendor/` ou de `node_modules/` (ils sont déjà dans `.gitignore`) ; ajoutez les fichiers un par un
(`git add chemin/du/fichier`) plutôt qu'avec `git add .`.

### Description de pull request

Le modèle `.github/pull_request_template.md` s'applique automatiquement. Il contient :

```markdown
## Ticket concerné
AC-05 · Anti-abus (docs/tickets/AC-05.md)

## Ce qui a été fait
- Règle de validation MaxReportsPerHour (3 signalements par téléphone sur une heure glissante)
- Message « Réessayez dans X minutes »

## Comment tester
1. php artisan migrate:fresh --seed
2. Envoyer 4 signalements avec le même téléphone

## Captures d'écran
Avant / après

## Checklist
- [x] Critères couverts par des tests (plus aucun ->todo())
- [x] php artisan test passe
- [x] ./vendor/bin/pint --test passe
- [x] Aucun secret ni fichier .env commité
```

## Licence

Code publié sous licence [MIT](LICENSE). Projet pédagogique de Dominium Academy.
