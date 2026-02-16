<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\RdvRequestController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ActualiteController;

// Services (lecture seule)
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{slug}', [ServiceController::class, 'show']);

// Actualités
Route::get('/actualites/categories', [ActualiteController::class, 'categories']);
Route::get('/actualites', [ActualiteController::class, 'index']);
Route::get('/actualites/{slug}', [ActualiteController::class, 'show']);

// Demandes RDV
Route::post('/rdv-requests', [RdvRequestController::class, 'store']);

// Messages contact
Route::post('/contacts', [ContactController::class, 'store']);



