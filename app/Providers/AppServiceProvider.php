<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // En développement, signale les requêtes oubliées dans une boucle (problème « N+1 »).
        // Solution : charger les relations à l'avance avec with() dans le contrôleur.
        Model::preventLazyLoading(! $this->app->isProduction());
    }
}
