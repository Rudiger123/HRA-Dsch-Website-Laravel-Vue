
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\RdvRequestController;
use App\Http\Controllers\Api\ContactController;

// Services (lecture seule)
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{slug}', [ServiceController::class, 'show']);

// Demandes RDV
Route::post('/rdv-requests', [RdvRequestController::class, 'store']);

// Messages contact
Route::post('/contacts', [ContactController::class, 'store']);
