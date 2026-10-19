<?php

declare(strict_types=1);

use App\Models\Commune;
use App\Models\Incident;
use App\Models\Neighborhood;
use App\Models\Report;

it('liste les signalements récents regroupés par commune, dans l\'ordre alphabétique', function () {
    $yopougon = Neighborhood::factory()->for(Commune::factory()->state(['name' => 'Yopougon']))->create(['name' => 'Niangon']);
    $cocody = Neighborhood::factory()->for(Commune::factory()->state(['name' => 'Cocody']))->create(['name' => 'Angré']);
    Report::factory()->for(Incident::factory()->for($yopougon))->create(['description' => 'Noir total à Niangon']);
    Report::factory()->for(Incident::factory()->water()->for($cocody))->create(['description' => 'Robinets à sec à Angré']);

    $this->get('/')
        ->assertOk()
        ->assertSeeInOrder(['Cocody', 'Angré', 'Robinets à sec à Angré', 'Yopougon', 'Niangon', 'Noir total à Niangon'])
        ->assertSee('Eau')
        ->assertSee('Électricité');
});

it('n\'affiche ni les signalements de plus de 48 heures ni les téléphones', function () {
    $old = Report::factory()->create(['description' => 'Coupure de la semaine dernière']);
    $old->forceFill(['created_at' => now()->subHours(49)])->save();
    Report::factory()->create(['description' => 'Coupure de ce soir', 'phone' => '0708998877']);

    $this->get('/')
        ->assertOk()
        ->assertSee('Coupure de ce soir')
        ->assertDontSee('Coupure de la semaine dernière')
        ->assertDontSee('0708998877');
});

it('indique quand aucune coupure n\'a été signalée', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('Aucune coupure signalée ces 48 dernières heures.');
});
