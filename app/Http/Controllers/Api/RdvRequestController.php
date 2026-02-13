<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RdvRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RdvRequestController extends Controller
{
    /**
     * Créer une nouvelle demande de RDV
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_patient' => 'required|string|max:150',
            'age' => 'nullable|integer|min:0|max:120',
            'telephone' => 'required|string|regex:/^\\+237[0-9]{9}$/',
            'service_id' => 'required|exists:services,id',
            'motif' => 'nullable|string|max:500',
            'confirmation_whatsapp' => 'boolean',
        ], [
            'telephone.regex' => 'Le numéro doit être au format +237XXXXXXXXX',
            'service_id.exists' => 'Le service sélectionné n\'existe pas',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $rdv = RdvRequest::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Demande de rendez-vous enregistrée avec succès. Nous vous contacterons sous 2 heures.',
            'data' => $rdv
        ], 201);
    }
}
