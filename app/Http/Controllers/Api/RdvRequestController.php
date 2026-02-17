<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NouveauRdvAdmin;
use App\Mail\ConfirmationRdvPatient;
use App\Models\RdvRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
            'email' => 'nullable|email',
            'service_id' => 'required|exists:services,id',
            'motif' => 'nullable|string|max:500',
            'confirmation_whatsapp' => 'boolean',
        ], [
            'nom_patient.min' => 'Le nom doit avoir au moins 3 caractères',
            'telephone.regex' => 'Format invalide. Ex: +237677123456',
            'email.email' => 'Format d\'email invalide',
            'service_id.exists' => 'Le service sélectionné n\'existe pas',
        ]);

        $rdv = RdvRequest::create($validated);

        // Envoyer emails
        try {
            // Email à l'admin
            Mail::to(config('services.hospital.admin_email'))
                ->send(new NouveauRdvAdmin($rdv));

            // Email au patient (si email fourni)
            if ($rdv->email) {
                Mail::to($rdv->email)
                    ->send(new ConfirmationRdvPatient($rdv));
            }
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email RDV: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Demande envoyée avec succès ! Nous vous rappelons sous 2 heures au ' . $validated['telephone'] . '.');
    }
}
