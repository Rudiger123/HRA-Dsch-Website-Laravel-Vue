<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Routes Web - HRAD Dschang
|--------------------------------------------------------------------------
*/

// Page d'accueil
use App\Models\Service;
Route::get('/', function () {
    return Inertia::render('Home', [
        'services' => Service::actif()->ordonne()->get()
    ]);
})->name('home');

// Page Services
Route::get('/services', function () {
    return Inertia::render('Services/Index', [
        'services' => Service::actif()->ordonne()->get()
    ]);
})->name('services');

// PAGE Équipe (liste médecins) - DOIT VENIR AVANT /services/{slug}
use App\Models\Medecin;
Route::get('/equipe', function () {
    $medecins = Medecin::actif()
        ->with('services')
        ->orderBy('nom')
        ->get();

    $specialites = $medecins->pluck('specialite')->unique()->values();

    return Inertia::render('Equipe/Index', [
        'medecins' => $medecins,
        'specialites' => $specialites
    ]);
})->name('equipe');

// PAGE Profil Médecin (détail) - DOIT VENIR AVANT /services/{slug}
Route::get('/equipe/{slug}', function ($slug) {
    $medecin = Medecin::where('slug', $slug)
        ->actif()
        ->with(['services' => function ($query) {
            $query->with('horaires');
        }])
        ->firstOrFail();

    return Inertia::render('Equipe/Show', [
        'medecin' => $medecin
    ]);
})->name('equipe.show');

// PAGE Service Detail (show) - DOIT VENIR APRÈS /equipe/{slug}
Route::get('/services/{slug}', function ($slug) {
    $service = Service::where('slug', $slug)
        ->with(['horaires', 'tarifs', 'medecins'])
        ->firstOrFail();

    return Inertia::render('Services/Show', [
        'service' => $service
    ]);
})->name('services.show');

// PAGE Tarifs
Route::get('/tarifs', function () {
    $services = Service::actif()
        ->with(['tarifs' => function($query) {
            $query->orderBy('designation');
        }])
        ->ordonne()
        ->get();

    return Inertia::render('Tarifs/Index', [
        'servicesTarifs' => $services
    ]);
})->name('tarifs');

Route::get('/rendez-vous', function () {
    return Inertia::render('RDV/Create', [
        'services' => Service::actif()->ordonne()->get()
    ]);
})->name('rdv');

Route::get('/contact', function () {
    return Inertia::render('Contact/Index');
})->name('contact');
// PAGE FAQ
Route::get('/faq', function () {
    return Inertia::render('FAQ');
})->name('faq');
