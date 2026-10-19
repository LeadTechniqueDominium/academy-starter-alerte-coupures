<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Moderation\ReportController as ModerationReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

/*
| Les URL sont en français (/signaler, /alertes...), les noms de routes en anglais (reports.create...).
| Liste complète : php artisan route:list
*/

// Pages publiques (citoyens et abonnés, sans compte).
Route::get('/', [ReportController::class, 'index'])->name('reports.index');
Route::get('/signaler', [ReportController::class, 'create'])->name('reports.create');
// throttle:10,1 : au plus 10 envois par minute depuis une même adresse, contre les robots.
Route::post('/signalements', [ReportController::class, 'store'])->middleware('throttle:10,1')->name('reports.store');
Route::get('/alertes', [SubscriberController::class, 'create'])->name('subscribers.create');
Route::post('/alertes', [SubscriberController::class, 'store'])->middleware('throttle:10,1')->name('subscribers.store');

// Connexion des modérateurs.
Route::middleware('guest')->group(function () {
    Route::get('/connexion', [LoginController::class, 'create'])->name('login');
    Route::post('/connexion', [LoginController::class, 'store'])->middleware('throttle:5,1');
});

// Espace modérateur.
Route::middleware('auth')->group(function () {
    Route::post('/deconnexion', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/moderation', [ModerationReportController::class, 'index'])->name('moderation.reports.index');
    Route::delete('/moderation/signalements/{report}', [ModerationReportController::class, 'destroy'])->name('moderation.reports.destroy');
});
