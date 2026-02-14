<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RdvRequest;
use Illuminate\Http\Request;

class RdvRequestController extends Controller
{
    /**
     * Créer une nouvelle demande de RDV
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_patient' => 'required|string|max:150|min:3',
            'age' => 'nullable|integer|min:0|max:120',
            'telephone' => 'required|string|regex:/^\+237[0-9]{9}$/',
            'service_id' => 'required|exists:services,id',
            'motif' => 'nullable|string|max:500',
            'confirmation_whatsapp' => 'boolean',
        ], [
            'nom_patient.min' => 'Le nom doit avoir au moins 3 caractères',
            'telephone.regex' => 'Format invalide. Ex: +237677123456',
            'service_id.exists' => 'Le service sélectionné n\'existe pas',
        ]);

        $rdv = RdvRequest::create($validated);

        return redirect()->back()->with('success', 'Demande envoyée avec succès ! Nous vous rappelons sous 2 heures au ' . $validated['telephone'] . '.');
    }
}
