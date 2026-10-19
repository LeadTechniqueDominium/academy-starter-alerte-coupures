<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CommuneFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Une commune d'Abidjan (Cocody, Yopougon...).
 */
#[Fillable(['name'])]
class Commune extends Model
{
    /** @use HasFactory<CommuneFactory> */
    use HasFactory;

    /**
     * @return HasMany<Neighborhood, $this>
     */
    public function neighborhoods(): HasMany
    {
        return $this->hasMany(Neighborhood::class)->orderBy('name');
    }
}
