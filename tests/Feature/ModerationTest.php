<?php

declare(strict_types=1);

use App\Models\Incident;
use App\Models\Report;

it('montre au modérateur la liste complète des signalements, avec les téléphones', function () {
    $recent = Report::factory()->create(['description' => 'Signalement récent', 'phone' => '0708112233']);
    $old = Report::factory()->create(['description' => 'Signalement ancien']);
    $old->forceFill(['created_at' => now()->subMonths(2)])->save();

    $this->actingAs(createModerator())
        ->get('/moderation')
        ->assertOk()
        ->assertSeeInOrder(['Signalement récent', 'Signalement ancien'])
        ->assertSee('0708112233');
});

it('pagine la liste par 20 signalements', function () {
    Report::factory()->count(25)->create();

    $this->actingAs(createModerator())
        ->get('/moderation')
        ->assertOk()
        ->assertViewHas('reports', fn ($reports) => $reports->count() === 20 && $reports->total() === 25);
});

it('supprime un signalement abusif et sa coupure devenue vide', function () {
    $report = Report::factory()->create();

    $this->actingAs(createModerator())
        ->from('/moderation')
        ->delete("/moderation/signalements/{$report->id}")
        ->assertRedirect('/moderation')
        ->assertSessionHas('success', 'Le signalement a été supprimé.');

    expect(Report::count())->toBe(0)
        ->and(Incident::count())->toBe(0);
});

it('garde la coupure si elle a encore d\'autres signalements', function () {
    $incident = Incident::factory()->create();
    $abusive = Report::factory()->for($incident)->create();
    Report::factory()->for($incident)->create();

    $this->actingAs(createModerator())->delete("/moderation/signalements/{$abusive->id}");

    expect($incident->fresh())->not->toBeNull()
        ->and($incident->reports()->count())->toBe(1);
});

it('interdit la suppression à un visiteur non connecté', function () {
    $report = Report::factory()->create();

    $this->delete("/moderation/signalements/{$report->id}")->assertRedirect('/connexion');

    expect(Report::count())->toBe(1);
});
