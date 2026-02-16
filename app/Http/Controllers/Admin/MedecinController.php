<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medecin;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class MedecinController extends Controller
{
    /**
     * Afficher liste des médecins
     */
    public function index(Request $request)
    {
        $this->authorize('view_medecins');
        $query = Medecin::with('services:id,nom');

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('specialite', 'like', "%{$search}%");
            });
        }

        // Filtrage par spécialité
        if ($request->has('specialite')) {
            $query->where('specialite', $request->specialite);
        }

        // Filtrage par statut
        if ($request->has('actif')) {
            $query->where('actif', $request->actif);
        }

        $medecins = $query->latest()->paginate(15);

        // Liste des spécialités pour filtre
        $specialites = Medecin::select('specialite')
            ->distinct()
            ->pluck('specialite');

        return Inertia::render('Admin/Medecins/Index', [
            'medecins' => $medecins,
            'specialites' => $specialites,
            'filters' => $request->only(['search', 'specialite', 'actif']),
        ]);
    }

    /**
     * Afficher formulaire création
     */
    public function create()
    {
        $this->authorize('create_medecins');

        $services = Service::where('actif', true)->orderBy('ordre')->get(['id', 'nom']);

        return Inertia::render('Admin/Medecins/Create', [
            'services' => $services,
        ]);
    }

    /**
     * Créer un médecin
     */
    public function store(Request $request)
    {
        $this->authorize('create_medecins');

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'specialite' => 'required|string|max:255',
            'diplomes' => 'required|string',
            'bio' => 'nullable|string',
            'langues' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'actif' => 'boolean',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
        ], [
            'nom.required' => 'Le nom est obligatoire',
            'specialite.required' => 'La spécialité est obligatoire',
            'diplomes.required' => 'Les diplômes sont obligatoires',
            'langues.required' => 'Les langues parlées sont obligatoires',
            'photo.image' => 'Le fichier doit être une image',
            'photo.mimes' => 'Format autorisé : JPEG, JPG, PNG',
            'photo.max' => 'Taille maximale : 2MB',
            'services.required' => 'Assignez au moins un service',
            'services.min' => 'Assignez au moins un service',
        ]);

        // Upload photo
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $dir = public_path('images/medecins');
            if (!is_dir($dir)) mkdir($dir, 0755, true);

            $filename = Str::uuid() . '.' . $photo->getClientOriginalExtension();
            $photo->move($dir, $filename);
            $validated['photo'] = '/images/medecins/' . $filename;
        }

        // Générer slug
        $validated['slug'] = Str::slug($validated['nom']);

        // Créer médecin
        $medecin = Medecin::create($validated);

        // Attacher services
        $medecin->services()->sync($request->services);

        // Logger l'activité
        activity()
            ->performedOn($medecin)
            ->causedBy(auth()->user())
            ->log('Médecin créé : Dr. ' . $medecin->nom);

        return redirect()->route('admin.medecins.index')
            ->with('success', 'Médecin créé avec succès');
    }

    /**
     * Afficher un médecin
     */
    public function show(Medecin $medecin)
    {
        $medecin->load('services');

        return Inertia::render('Admin/Medecins/Show', [
            'medecin' => $medecin,
        ]);
    }

    /**
     * Afficher formulaire édition
     */
    public function edit(Medecin $medecin)
    {
        $this->authorize('edit_medecins');

        $medecin->load('services:id');
        $services = Service::where('actif', true)->orderBy('ordre')->get(['id', 'nom']);

        return Inertia::render('Admin/Medecins/Edit', [
            'medecin' => $medecin,
            'services' => $services,
            'medecinServices' => $medecin->services->pluck('id'),
        ]);
    }

    /**
     * Mettre à jour un médecin
     */
    public function update(Request $request, Medecin $medecin)
    {
        $this->authorize('edit_medecins');

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'specialite' => 'required|string|max:255',
            'diplomes' => 'required|string',
            'bio' => 'nullable|string',
            'langues' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'actif' => 'boolean',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
        ]);

        // Upload nouvelle photo
        if ($request->hasFile('photo')) {
            // Supprimer ancienne photo
            if ($medecin->photo && file_exists(public_path($medecin->photo))) {
                unlink(public_path($medecin->photo));
            }

            $photo = $request->file('photo');
            $dir = public_path('images/medecins');
            if (!is_dir($dir)) mkdir($dir, 0755, true);

            $filename = Str::uuid() . '.' . $photo->getClientOriginalExtension();
            $photo->move($dir, $filename);
            $validated['photo'] = '/images/medecins/' . $filename;
        }

        // Regénérer slug si nom changé
        if ($medecin->nom !== $validated['nom']) {
            $validated['slug'] = Str::slug($validated['nom']);
        }

        $medecin->update($validated);

        // Mettre à jour services
        $medecin->services()->sync($request->services);

        // Logger l'activité
        activity()
            ->performedOn($medecin)
            ->causedBy(auth()->user())
            ->log('Médecin modifié : Dr. ' . $medecin->nom);

        return redirect()->route('admin.medecins.index')
            ->with('success', 'Médecin modifié avec succès');
    }

    /**
     * Supprimer un médecin
     */
    public function destroy(Medecin $medecin)
    {
        $this->authorize('delete_medecins');
        $nomMedecin = $medecin->nom;

        // Désactiver plutôt que supprimer
        $medecin->update(['actif' => false]);

        // Logger l'activité
        activity()
            ->performedOn($medecin)
            ->causedBy(auth()->user())
            ->log('Médecin désactivé : Dr. ' . $nomMedecin);

        return redirect()->route('admin.medecins.index')
            ->with('success', 'Médecin désactivé avec succès');
    }

    /**
     * Supprimer la photo d'un médecin
     */
    public function deletePhoto(Medecin $medecin)
    {
        $this->authorize('edit_medecins');

        if ($medecin->photo && file_exists(public_path($medecin->photo))) {
            unlink(public_path($medecin->photo));
        }

        $medecin->update(['photo' => null]);

        return back()->with('success', 'Photo supprimée avec succès');
    }
}
