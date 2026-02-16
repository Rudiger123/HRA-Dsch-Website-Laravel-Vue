<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Activitylog\Models\Activity;

class LoginController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function showLoginForm()
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Traiter la connexion
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'Format d\'email invalide',
            'password.required' => 'Le mot de passe est obligatoire',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Vérifier si l'utilisateur est actif
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Votre compte a été désactivé. Contactez l\'administrateur.',
                ]);
            }

            // Logger l'activité
            activity()
                ->causedBy($user)
                ->log('Connexion réussie');

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis sont incorrects.',
        ])->onlyInput('email');
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Logger l'activité
        activity()
            ->causedBy($user)
            ->log('Déconnexion');

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
