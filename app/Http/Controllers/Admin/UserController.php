<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NouveauCompteUtilisateur;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Afficher liste des utilisateurs
     */
    public function index(Request $request)
    {
        $this->authorize('view_users');
        $query = User::with('roles');

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filtrage par rôle
        if ($request->has('role')) {
            $query->role($request->role);
        }

        // Filtrage par statut
        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Pagination avec nombre d'éléments par page configurable (défaut 7)
        $perPage = $request->get('per_page', 7);
        $perPage = min($perPage, 100); // Limite max 100
        $users = $query->latest()->paginate($perPage);

        $roles = Role::all(['id', 'name']);

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'roles' => $roles,
            'filters' => $request->only(['search', 'role', 'is_active', 'per_page']),
        ]);
    }

    /**
     * Afficher formulaire création
     */
    public function create()
    {        $this->authorize('create_users');
                $roles = Role::all(['id', 'name']);

        return Inertia::render('Admin/Users/Create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Créer un utilisateur
     */
    public function store(Request $request)
    {
        $this->authorize('create_users');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'nullable|string|regex:/^\+237[0-9]{9}$/',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => 'required|exists:roles,name',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'name.required' => 'Le nom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'Format d\'email invalide',
            'email.unique' => 'Cet email est déjà utilisé',
            'phone.regex' => 'Format téléphone invalide (ex: +237677123456)',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
            'role.required' => 'Le rôle est obligatoire',
        ]);

        // Upload photo
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $dir = public_path('images/users');
            if (!is_dir($dir)) mkdir($dir, 0755, true);

            $filename = Str::uuid() . '.' . $photo->getClientOriginalExtension();
            $photo->move($dir, $filename);
            $validated['photo'] = '/images/users/' . $filename;
        }

        // Créer utilisateur
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'photo' => $validated['photo'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // Assigner rôle
        $user->assignRole($validated['role']);

        // Envoyer email au nouveau compte
        try {
            Mail::to($user->email)
                ->send(new NouveauCompteUtilisateur($user, $validated['password']));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email nouveau compte: ' . $e->getMessage());
        }

        // Logger l'activité
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->log('Utilisateur créé : ' . $user->name . ' (' . $validated['role'] . ')');

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès');
    }

    /**
     * Afficher un utilisateur
     */
    public function show(User $user)
    {
        $user->load('roles', 'permissions');

        // Activité de l'utilisateur
        $activite = \Spatie\Activitylog\Models\Activity::where('causer_id', $user->id)
            ->where('causer_type', User::class)
            ->latest()
            ->limit(20)
            ->get();

        return Inertia::render('Admin/Users/Show', [
            'user' => $user,
            'activite' => $activite,
        ]);
    }

    /**
     * Afficher formulaire édition
     */
    public function edit(User $user)
    {
        // Empêcher modification de son propre compte via cette route
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.profile.edit')
                ->with('info', 'Utilisez la page "Mon Profil" pour modifier vos informations');
        }

        $user->load('roles');
        $roles = Role::all(['id', 'name']);

        return Inertia::render('Admin/Users/Edit', [
            'user' => $user,
            'roles' => $roles,
            'userRole' => $user->roles->first()?->name,
        ]);
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        // Empêcher modification de son propre compte
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Utilisez la page "Mon Profil" pour modifier vos informations');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|regex:/^\+237[0-9]{9}$/',
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'role' => 'required|exists:roles,name',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Upload nouvelle photo
        if ($request->hasFile('photo')) {
            // Supprimer ancienne photo
            if ($user->photo && file_exists(public_path($user->photo))) {
                unlink(public_path($user->photo));
            }

            $photo = $request->file('photo');
            $dir = public_path('images/users');
            if (!is_dir($dir)) mkdir($dir, 0755, true);

            $filename = Str::uuid() . '.' . $photo->getClientOriginalExtension();
            $photo->move($dir, $filename);
            $validated['photo'] = '/images/users/' . $filename;
        }

        // Mettre à jour mot de passe si fourni
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        // Mettre à jour rôle
        $user->syncRoles([$validated['role']]);

        // Logger l'activité
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->log('Utilisateur modifié : ' . $user->name);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur modifié avec succès');
    }

    /**
     * Supprimer un utilisateur (soft delete)
     */
    public function destroy(User $user)
    {
        // Empêcher suppression de son propre compte
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte');
        }

        // Empêcher suppression du super admin principal
        if ($user->email === 'admin@hradschang.cm') {
            return back()->with('error', 'Le compte super admin principal ne peut pas être supprimé');
        }

        $nomUser = $user->name;

        $user->delete();

        // Logger l'activité
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->log('Utilisateur supprimé : ' . $nomUser);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès');
    }

    /**
     * Activer/Désactiver un utilisateur
     */
    public function toggleActive(User $user)
    {
        // Empêcher désactivation de son propre compte
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas désactiver votre propre compte');
        }

        $user->update(['is_active' => !$user->is_active]);

        $action = $user->is_active ? 'activé' : 'désactivé';

        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->log("Utilisateur {$action} : {$user->name}");

        return back()->with('success', "Utilisateur {$action} avec succès");
    }

    /**
     * Réinitialiser mot de passe
     */
    public function resetPassword(User $user)
    {
        $this->authorize('edit_users');

        // Générer nouveau mot de passe temporaire
        $newPassword = Str::random(12);

        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        // Logger l'activité
        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->log('Mot de passe réinitialisé pour : ' . $user->name);

        return back()->with('success', 'Mot de passe réinitialisé.');
    }
}
