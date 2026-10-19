<?php

declare(strict_types=1);

use App\Enums\IncidentStatus;
use App\Enums\OutageType;
use App\Models\Commune;
use App\Models\Incident;
use App\Models\Neighborhood;
use App\Models\Report;

it('affiche le formulaire de signalement avec les quartiers regroupés par commune', function () {
    $commune = Commune::factory()->create(['name' => 'Cocody']);
    Neighborhood::factory()->for($commune)->create(['name' => 'Angré']);

    $this->get('/signaler')
        ->assertOk()
        ->assertSee('Signaler une coupure')
        ->assertSee('<optgroup label="Cocody">', false)
        ->assertSee('Angré')
        ->assertSee('Électricité');
});

it('enregistre un signalement et ouvre une coupure en cours', function () {
    $neighborhood = Neighborhood::factory()->create();

    $this->post('/signalements', [
        'type' => OutageType::Water->value,
        'neighborhood_id' => $neighborhood->id,
        'description' => 'Plus d\'eau depuis ce matin.',
        'phone' => '07 08 11 22 33',
    ])->assertRedirect('/')->assertSessionHas('success');

    $report = Report::sole();
    $incident = $report->incident;

    expect($report->phone)->toBe('0708112233')
        ->and($report->description)->toBe('Plus d\'eau depuis ce matin.')
        ->and($incident->type)->toBe(OutageType::Water)
        ->and($incident->status)->toBe(IncidentStatus::Active)
        ->and($incident->neighborhood_id)->toBe($neighborhood->id)
        ->and($incident->started_at)->not->toBeNull();
});

it('crée une coupure par signalement (pas encore de regroupement)', function () {
    $neighborhood = Neighborhood::factory()->create();
    $data = ['type' => 'electricity', 'neighborhood_id' => $neighborhood->id, 'description' => 'Pas de courant.', 'phone' => '0708112233'];

    $this->post('/signalements', $data);
    $this->post('/signalements', array_merge($data, ['phone' => '0505112233']));

    expect(Incident::count())->toBe(2)
        ->and(Report::count())->toBe(2);
});

it('valide le formulaire de signalement', function (array $data, string $field) {
    $neighborhood = Neighborhood::factory()->create();

    $this->post('/signalements', array_merge([
        'type' => 'electricity',
        'neighborhood_id' => $neighborhood->id,
        'description' => 'Pas de courant.',
        'phone' => '0708112233',
    ], $data))->assertSessionHasErrors($field);

    expect(Report::count())->toBe(0);
})->with([
    'type inconnu' => [['type' => 'gaz'], 'type'],
    'quartier absent' => [['neighborhood_id' => ''], 'neighborhood_id'],
    'quartier inconnu' => [['neighborhood_id' => 999], 'neighborhood_id'],
    'description vide' => [['description' => ''], 'description'],
    'description trop longue' => [['description' => str_repeat('a', 501)], 'description'],
    'téléphone invalide' => [['phone' => '0908112233'], 'phone'],
]);
