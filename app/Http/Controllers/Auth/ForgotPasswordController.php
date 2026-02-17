<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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

        // Trouver l'utilisateur
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Aucun compte trouvé avec cet email']);
        }

        // Générer un token de réinitialisation
        $token = Password::getRepository()->create($user);

        // Envoyer le mail personnalisé
        try {
            Mail::send(new PasswordResetMail(
                token: $token,
                email: $user->email,
                userName: $user->name
            ));

            // Logger l'activité
            activity()
                ->causedBy($user)
                ->log('Demande de réinitialisation de mot de passe');

            return back()->with('status', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Impossible d\'envoyer le lien de réinitialisation. Veuillez réessayer plus tard.']);
        }
    }
}
