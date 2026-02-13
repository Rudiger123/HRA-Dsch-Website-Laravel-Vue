<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Routes Web - HRAD Dschang
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

// Routes à venir
Route::get('/services', function () {
    return Inertia::render('Services/Index');
})->name('services');

Route::get('/rdv', function () {
    return Inertia::render('RDV/Index');
})->name('rdv');

Route::get('/contact', function () {
    return Inertia::render('Contact/Index');
})->name('contact');
