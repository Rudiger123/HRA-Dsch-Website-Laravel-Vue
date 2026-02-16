<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

class ForgotPasswordController extends Controller
{
    /**
     * Afficher le formulaire de demande de réinitialisation
     */
    public function showLinkRequestForm()
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    /**
     * Envoyer le lien de réinitialisation
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'Format d\'email invalide',
            'email.exists' => 'Aucun compte trouvé avec cet email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Un lien de réinitialisation a été envoyé à votre adresse email.')
            : back()->withErrors(['email' => 'Impossible d\'envoyer le lien de réinitialisation.']);
    }
}
