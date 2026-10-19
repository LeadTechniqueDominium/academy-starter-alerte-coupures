<?php

declare(strict_types=1);

use App\Models\Neighborhood;
use App\Models\Subscriber;

it('affiche le formulaire d\'abonnement aux alertes', function () {
    $this->get('/alertes')
        ->assertOk()
        ->assertSee('Recevoir les alertes de votre quartier');
});

it('abonne un téléphone aux alertes d\'un quartier', function () {
    $neighborhood = Neighborhood::factory()->create();

    $this->post('/alertes', ['phone' => '05 05 22 33 44', 'neighborhood_id' => $neighborhood->id])
        ->assertRedirect('/alertes')
        ->assertSessionHas('success');

    expect(Subscriber::sole())
        ->phone->toBe('0505223344')
        ->neighborhood_id->toBe($neighborhood->id);
});

it('refuse d\'abonner deux fois le même téléphone au même quartier', function () {
    $neighborhood = Neighborhood::factory()->create();
    Subscriber::factory()->for($neighborhood)->create(['phone' => '0505223344']);

    $this->post('/alertes', ['phone' => '0505223344', 'neighborhood_id' => $neighborhood->id])
        ->assertSessionHasErrors(['phone' => 'Ce numéro est déjà abonné aux alertes de ce quartier.']);

    expect(Subscriber::count())->toBe(1);
});

it('accepte le même téléphone pour un autre quartier', function () {
    Subscriber::factory()->create(['phone' => '0505223344']);
    $other = Neighborhood::factory()->create();

    $this->post('/alertes', ['phone' => '0505223344', 'neighborhood_id' => $other->id])
        ->assertSessionHasNoErrors();

    expect(Subscriber::count())->toBe(2);
});

it('valide le formulaire d\'abonnement', function (array $data, string $field) {
    $neighborhood = Neighborhood::factory()->create();

    $this->post('/alertes', array_merge(['phone' => '0505223344', 'neighborhood_id' => $neighborhood->id], $data))
        ->assertSessionHasErrors($field);
})->with([
    'téléphone absent' => [['phone' => ''], 'phone'],
    'téléphone invalide' => [['phone' => '123'], 'phone'],
    'quartier inconnu' => [['neighborhood_id' => 999], 'neighborhood_id'],
]);
