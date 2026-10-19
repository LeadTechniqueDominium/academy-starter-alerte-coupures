<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\IncidentStatus;
use App\Enums\OutageType;
use App\Models\Neighborhood;
use App\Models\Subscriber;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Données de démonstration : communes et quartiers d'Abidjan, un modérateur, des abonnés,
 * des signalements récents et un historique de coupures résolues sur 40 jours.
 * Le compte modérateur a le mot de passe « password ».
 *
 * Lancement : php artisan migrate:fresh --seed
 */
class DatabaseSeeder extends Seeder
{
    private const WATER_DESCRIPTIONS = [
        'Plus une goutte d\'eau au robinet depuis ce matin.',
        'L\'eau coule très faiblement, impossible de remplir les bidons.',
        'Coupure d\'eau dans tout le bloc depuis hier soir.',
        'L\'eau est sortie trouble, puis plus rien depuis 6 h.',
    ];

    private const ELECTRICITY_DESCRIPTIONS = [
        'Plus de courant dans toute la rue depuis 19 h.',
        'Le courant va et vient depuis une heure, les appareils s\'éteignent.',
        'Transformateur en panne au carrefour, tout le quartier est dans le noir.',
        'Coupure d\'électricité depuis ce matin, les commerces sont fermés.',
    ];

    /**
     * Signalements récents : commune, quartier, type, il y a combien de minutes, durée en minutes si résolue.
     *
     * @var array<int, array{0: string, 1: string, 2: OutageType, 3: int, 4: int|null}>
     */
    private const RECENT = [
        ['Cocody', 'Angré', OutageType::Electricity, 60, null],
        ['Cocody', 'Angré', OutageType::Electricity, 50, null],
        ['Cocody', 'Riviera 2', OutageType::Water, 180, null],
        ['Cocody', 'II Plateaux', OutageType::Water, 540, null],
        ['Yopougon', 'Niangon', OutageType::Electricity, 120, null],
        ['Yopougon', 'Niangon', OutageType::Electricity, 90, null],
        ['Yopougon', 'Selmer', OutageType::Electricity, 150, null],
        ['Yopougon', 'Maroc', OutageType::Water, 300, null],
        ['Abobo', 'PK 18', OutageType::Water, 360, null],
        ['Abobo', 'Sagbé', OutageType::Electricity, 200, null],
        ['Abobo', 'Abobo Gare', OutageType::Electricity, 1560, 240],
        ['Koumassi', 'Remblais', OutageType::Electricity, 240, null],
        ['Koumassi', 'Grand Campement', OutageType::Water, 2100, 360],
        ['Marcory', 'Zone 4', OutageType::Water, 480, 180],
        ['Port-Bouët', 'Vridi', OutageType::Electricity, 720, 300],
        ['Treichville', 'Arras', OutageType::Water, 420, null],
        ['Adjamé', 'Williamsville', OutageType::Electricity, 1800, 120],
        ['Attécoubé', 'Locodjro', OutageType::Water, 1200, null],
        ['Bingerville', 'Akandjé', OutageType::Electricity, 600, null],
        ['Anyama', 'Anyama Centre', OutageType::Water, 2400, 600],
        ['Songon', 'Songon-Kassemblé', OutageType::Electricity, 900, null],
        ['Plateau', 'Indénié', OutageType::Electricity, 45, null],
    ];

    /**
     * Historique : quartier, type, il y a combien de jours, durée en heures (coupures résolues).
     *
     * @var array<int, array{0: string, 1: string, 2: OutageType, 3: int, 4: int}>
     */
    private const HISTORY = [
        ['Cocody', 'Angré', OutageType::Electricity, 3, 4],
        ['Cocody', 'Angré', OutageType::Water, 6, 12],
        ['Cocody', 'Angré', OutageType::Electricity, 12, 2],
        ['Cocody', 'Angré', OutageType::Electricity, 25, 6],
        ['Cocody', 'Angré', OutageType::Water, 35, 8],
        ['Yopougon', 'Niangon', OutageType::Electricity, 2, 5],
        ['Yopougon', 'Niangon', OutageType::Electricity, 8, 3],
        ['Yopougon', 'Niangon', OutageType::Water, 15, 20],
        ['Yopougon', 'Niangon', OutageType::Electricity, 21, 1],
        ['Yopougon', 'Niangon', OutageType::Water, 40, 10],
        ['Abobo', 'PK 18', OutageType::Water, 5, 30],
        ['Abobo', 'PK 18', OutageType::Water, 18, 16],
        ['Abobo', 'PK 18', OutageType::Electricity, 28, 4],
        ['Koumassi', 'Remblais', OutageType::Electricity, 4, 3],
        ['Koumassi', 'Remblais', OutageType::Electricity, 10, 7],
        ['Marcory', 'Zone 4', OutageType::Water, 9, 5],
        ['Port-Bouët', 'Vridi', OutageType::Electricity, 14, 9],
        ['Treichville', 'Arras', OutageType::Water, 22, 14],
    ];

    /**
     * Abonnés : téléphone et quartier.
     *
     * @var array<int, array{0: string, 1: string, 2: string}>
     */
    private const SUBSCRIBERS = [
        ['0708112233', 'Cocody', 'Angré'],
        ['0505223344', 'Cocody', 'Angré'],
        ['0102334455', 'Cocody', 'Angré'],
        ['0707445566', 'Yopougon', 'Niangon'],
        ['0506556677', 'Yopougon', 'Niangon'],
        ['0103667788', 'Abobo', 'PK 18'],
        ['0709778899', 'Koumassi', 'Remblais'],
        ['0504889900', 'Cocody', 'Riviera 2'],
    ];

    private int $reportIndex = 0;

    public function run(): void
    {
        $this->call(AbidjanSeeder::class);

        User::create([
            'name' => 'Koffi Adou',
            'email' => 'moderateur@alerte-coupures.test',
            'password' => Hash::make('password'),
        ]);

        foreach (self::SUBSCRIBERS as [$phone, $commune, $neighborhood]) {
            Subscriber::create(['phone' => $phone, 'neighborhood_id' => $this->neighborhood($commune, $neighborhood)->id]);
        }

        foreach (self::HISTORY as [$commune, $neighborhood, $type, $daysAgo, $durationHours]) {
            $startedAt = now()->subDays($daysAgo)->setTime(7 + $daysAgo % 12, 15);
            $this->createIncident($commune, $neighborhood, $type, $startedAt, $startedAt->copy()->addHours($durationHours));
        }

        foreach (self::RECENT as [$commune, $neighborhood, $type, $minutesAgo, $durationMinutes]) {
            $startedAt = now()->subMinutes($minutesAgo);
            $resolvedAt = $durationMinutes === null ? null : $startedAt->copy()->addMinutes($durationMinutes);
            $this->createIncident($commune, $neighborhood, $type, $startedAt, $resolvedAt);
        }
    }

    /**
     * Crée une coupure et son signalement (un signalement par coupure, voir App\Actions\SubmitReport).
     */
    private function createIncident(string $commune, string $neighborhood, OutageType $type, CarbonInterface $startedAt, ?CarbonInterface $resolvedAt): void
    {
        $incident = $this->neighborhood($commune, $neighborhood)->incidents()->create([
            'type' => $type,
            'status' => $resolvedAt === null ? IncidentStatus::Active : IncidentStatus::Resolved,
            'started_at' => $startedAt,
            'resolved_at' => $resolvedAt,
        ]);

        $descriptions = $type === OutageType::Water ? self::WATER_DESCRIPTIONS : self::ELECTRICITY_DESCRIPTIONS;

        $report = $incident->reports()->create([
            'description' => $descriptions[$this->reportIndex % count($descriptions)],
            'phone' => '07'.str_pad((string) (20304050 + $this->reportIndex * 1317), 8, '0', STR_PAD_LEFT),
        ]);

        // L'heure du signalement est celle du début de la coupure.
        $report->forceFill(['created_at' => $startedAt, 'updated_at' => $startedAt])->save();

        $this->reportIndex++;
    }

    private function neighborhood(string $commune, string $name): Neighborhood
    {
        return Neighborhood::query()
            ->where('name', $name)
            ->whereRelation('commune', 'name', $commune)
            ->firstOrFail();
    }
}
