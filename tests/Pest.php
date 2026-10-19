<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Configuration des tests
|--------------------------------------------------------------------------
|
| Tous les tests utilisent le TestCase de Laravel et une base SQLite en mémoire,
| remise à zéro avant chaque test (RefreshDatabase). Voir phpunit.xml.
|
*/

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Fonctions utiles dans les tests
|--------------------------------------------------------------------------
*/

/**
 * Crée un modérateur (seuls les modérateurs ont un compte).
 */
function createModerator(): User
{
    return User::factory()->create();
}
