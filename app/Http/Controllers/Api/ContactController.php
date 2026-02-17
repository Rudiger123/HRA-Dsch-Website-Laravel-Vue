<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NouveauMessageAdmin;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    /**
     * Créer un nouveau message de contact
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:150|min:3',
            'email' => 'required|email|max:150',
            'telephone' => 'nullable|string|max:20',
            'message' => 'required|string|max:1000|min:10',
        ], [
            'nom.min' => 'Le nom doit avoir au moins 3 caractères',
            'message.min' => 'Le message doit avoir au moins 10 caractères',
        ]);

        $contact = Contact::create($validated);

        // Envoyer email à l'admin
        try {
            Mail::to(config('services.hospital.admin_email'))
                ->send(new NouveauMessageAdmin($contact));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email contact: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Message envoyé avec succès. Nous vous répondrons dans les 24 heures.');
    }
}
