<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\RdvRequestController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ActualiteController;
use App\Http\Controllers\Api\ActualiteLikeController;
use App\Http\Controllers\Api\SearchController;

// Recherche globale (authentifiée)
Route::middleware('auth')->post('/search/global', [SearchController::class, 'global'])->name('search.global');

// Services (lecture seule)
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{slug}', [ServiceController::class, 'show']);

// Actualités
Route::get('/actualites/categories', [ActualiteController::class, 'categories']);
Route::get('/actualites', [ActualiteController::class, 'index']);
Route::get('/actualites/{slug}', [ActualiteController::class, 'show']);

// Likes/Réactions aux actualités
Route::post('/actualites/{actualite}/like', [ActualiteLikeController::class, 'toggle']);
Route::get('/actualites/{actualite}/like/stats', [ActualiteLikeController::class, 'stats']);
Route::get('/actualites/{actualite}/like/user-reaction', [ActualiteLikeController::class, 'userReaction']);

// Demandes RDV
Route::post('/rdv-requests', [RdvRequestController::class, 'store']);

// Messages contact
Route::post('/contacts', [ContactController::class, 'store']);



