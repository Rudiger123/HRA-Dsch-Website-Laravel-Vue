<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Afficher le profil
     */
    public function edit()
    {
        $user = auth()->user();
        $user->load('roles');

        return Inertia::render('Admin/Profile/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * Mettre à jour les informations du profil
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|regex:/^\+237[0-9]{9}$/',
        ], [
            'name.required' => 'Le nom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'Format d\'email invalide',
            'email.unique' => 'Cet email est déjà utilisé',
            'phone.regex' => 'Format téléphone invalide (ex: +237677123456)',
        ]);

        $user->update($validated);

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->log('Profil mis à jour');

        return back()->with('success', 'Profil mis à jour avec succès');
    }

    /**
     * Mettre à jour la photo de profil
     */
    public function updatePhoto(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'photo.required' => 'La photo est obligatoire',
            'photo.image' => 'Le fichier doit être une image',
            'photo.mimes' => 'Format autorisé : JPEG, JPG, PNG',
            'photo.max' => 'Taille maximale : 2MB',
        ]);

        // Supprimer ancienne photo
        if ($user->photo && file_exists(public_path($user->photo))) {
            unlink(public_path($user->photo));
        }

        // Upload nouvelle photo
        $photo = $request->file('photo');
        $dir = public_path('images/users');
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $filename = Str::uuid() . '.' . $photo->getClientOriginalExtension();
        $photo->move($dir, $filename);

        $user->update(['photo' => '/images/users/' . $filename]);

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->log('Photo de profil mise à jour');

        return back()->with('success', 'Photo mise à jour avec succès');
    }

    /**
     * Supprimer la photo de profil
     */
    public function deletePhoto()
    {
        $user = auth()->user();

        if ($user->photo && file_exists(public_path($user->photo))) {
            unlink(public_path($user->photo));
        }

        $user->update(['photo' => null]);

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->log('Photo de profil supprimée');

        return back()->with('success', 'Photo supprimée avec succès');
    }

    /**
     * Changer le mot de passe
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Le mot de passe actuel est obligatoire',
            'password.required' => 'Le nouveau mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
        ]);

        // Vérifier mot de passe actuel
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Le mot de passe actuel est incorrect'
            ]);
        }

        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->log('Mot de passe changé');

        return back()->with('success', 'Mot de passe changé avec succès');
    }
}
