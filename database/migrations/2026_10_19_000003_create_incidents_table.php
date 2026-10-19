<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Une coupure (incident) : un type, un quartier, un début et éventuellement une fin.
        // Pour l'instant, chaque signalement crée sa propre coupure (le regroupement est le ticket AC-03).
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            // Type : voir App\Enums\OutageType (water ou electricity).
            $table->string('type');
            $table->foreignId('neighborhood_id')->constrained()->cascadeOnDelete();
            // Statut : voir App\Enums\IncidentStatus (active ou resolved).
            $table->string('status')->default('active');
            $table->timestamp('started_at');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['neighborhood_id', 'type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
