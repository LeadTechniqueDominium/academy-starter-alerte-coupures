<?php

declare(strict_types=1);

use App\Models\Commune;
use App\Models\Neighborhood;
use App\Models\Report;
use App\Models\Subscriber;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

it('crée les données de démonstration décrites dans le README', function () {
    $this->seed(DatabaseSeeder::class);

    expect(Commune::count())->toBe(13)
        ->and(Neighborhood::count())->toBeGreaterThanOrEqual(55)
        ->and(Report::where('created_at', '>=', now()->subHours(48))->count())->toBeGreaterThan(10)
        ->and(Report::where('created_at', '<', now()->subDays(30))->exists())->toBeTrue()
        ->and(Subscriber::count())->toBeGreaterThan(0)
        ->and(User::where('email', 'moderateur@alerte-coupures.test')->exists())->toBeTrue();
});

it('affiche les signalements de démonstration et permet la connexion du modérateur', function () {
    $this->seed(DatabaseSeeder::class);

    $this->get('/')->assertOk()->assertSee('Cocody')->assertSee('Angré');

    $this->post('/connexion', ['email' => 'moderateur@alerte-coupures.test', 'password' => 'password'])
        ->assertRedirect(route('moderation.reports.index'));
});
