<?php

declare(strict_types=1);

use App\Actions\SubmitReport;
use App\Enums\IncidentStatus;
use App\Enums\OutageType;
use App\Models\Neighborhood;

it('crée la coupure et son signalement ensemble', function () {
    $neighborhood = Neighborhood::factory()->create();
    $this->travelTo(now()->setTime(19, 30));

    $report = app(SubmitReport::class)->handle(OutageType::Electricity, $neighborhood, 'Pas de courant.', '0708112233');

    expect($report->exists)->toBeTrue()
        ->and($report->incident->type)->toBe(OutageType::Electricity)
        ->and($report->incident->status)->toBe(IncidentStatus::Active)
        ->and($report->incident->started_at->format('H:i'))->toBe('19:30');
});
