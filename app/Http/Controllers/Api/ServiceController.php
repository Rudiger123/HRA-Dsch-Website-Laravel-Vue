<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Liste tous les services actifs avec relations
     */
    public function index()
    {
        return Service::actif()
            ->ordonne()
            ->with(['horaires', 'tarifs', 'medecins'])
            ->get();
    }

    /**
     * Affiche un service par slug
     */
    public function show($slug)
    {
        return Service::where('slug', $slug)
            ->with(['horaires', 'tarifs', 'medecins'])
            ->firstOrFail();
    }
}
