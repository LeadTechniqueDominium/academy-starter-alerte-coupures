<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Commune;
use Illuminate\Database\Seeder;

/**
 * Les 13 communes du District autonome d'Abidjan et une soixantaine de leurs quartiers.
 */
class AbidjanSeeder extends Seeder
{
    /**
     * @var array<string, array<int, string>>
     */
    public const COMMUNES = [
        'Abobo' => ['Abobo Gare', 'PK 18', 'Avocatier', 'Sagbé', 'Anonkoua-Kouté'],
        'Adjamé' => ['Williamsville', '220 Logements', 'Bracodi', 'Adjamé Village', 'Liberté'],
        'Anyama' => ['Anyama Centre', 'Ébimpé', 'Akoupé-Zeudji'],
        'Attécoubé' => ['Locodjro', 'Santé', 'Agban Village', 'Abobo-Doumé'],
        'Bingerville' => ['Bingerville Centre', 'Akandjé', 'Santai', 'Fèh Kessé'],
        'Cocody' => ['Angré', 'Riviera 2', 'Riviera Palmeraie', 'II Plateaux', 'Blockhauss', 'Danga', 'Saint-Jean', 'Mermoz'],
        'Koumassi' => ['Remblais', 'Grand Campement', 'Sicogi', 'Divo'],
        'Marcory' => ['Zone 4', 'Biétry', 'Anoumabo', 'Marcory Résidentiel'],
        'Plateau' => ['Cité administrative', 'Indénié', 'Quartier du Commerce'],
        'Port-Bouët' => ['Vridi', 'Gonzagueville', 'Jean Folly', 'Adjouffou', 'Derrière Wharf'],
        'Songon' => ['Songon-Kassemblé', 'Songon Té', 'Songon M\'Bratté'],
        'Treichville' => ['Arras', 'Biafra', 'Belleville', 'Notre-Dame'],
        'Yopougon' => ['Niangon', 'Sicogi', 'Selmer', 'Toits Rouges', 'Maroc', 'Banco 2', 'Wassakara', 'Andokoi'],
    ];

    public function run(): void
    {
        foreach (self::COMMUNES as $communeName => $neighborhoods) {
            $commune = Commune::create(['name' => $communeName]);

            foreach ($neighborhoods as $neighborhoodName) {
                $commune->neighborhoods()->create(['name' => $neighborhoodName]);
            }
        }
    }
}
