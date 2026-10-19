<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Un abonné aux alertes d'un quartier (sans compte : un téléphone et un quartier).
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 20);
            $table->foreignId('neighborhood_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['phone', 'neighborhood_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};
