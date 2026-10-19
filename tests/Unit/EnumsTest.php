<?php

declare(strict_types=1);

use App\Enums\IncidentStatus;
use App\Enums\OutageType;

it('donne un libellé français aux types de coupure et aux statuts', function () {
    expect(OutageType::Water->label())->toBe('Eau')
        ->and(OutageType::Electricity->label())->toBe('Électricité')
        ->and(IncidentStatus::Active->label())->toBe('En cours')
        ->and(IncidentStatus::Resolved->label())->toBe('Résolue');
});
