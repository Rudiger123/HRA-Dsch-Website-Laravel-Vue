<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Afficher liste des services
     */
    public function index(Request $request)
    {
        $this->authorize('view_services');

        $query = Service::with(['medecins:id,nom,specialite', 'horaires', 'tarifs'])
            ->withCount('rdvRequests');

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtrage par statut
        if ($request->has('actif')) {
            $query->where('actif', $request->actif);
        }

        // Tri
        $sortField = $request->get('sort', 'ordre');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        // Pagination avec nombre d'éléments par page configurable (défaut 7)
        $perPage = $request->get('per_page', 7);
        $perPage = min($perPage, 100); // Limite max 100
        $services = $query->paginate($perPage);

        return Inertia::render('Admin/Services/Index', [
            'services' => $services,
            'filters' => $request->only(['search', 'actif', 'sort', 'direction', 'per_page']),
        ]);
    }

    /**
     * Afficher formulaire création
     */
    public function create()
    {
        $this->authorize('create_services');
        return Inertia::render('Admin/Services/Create');
    }

    /**
     * Créer un service
     */
    public function store(Request $request)
    {
        $this->authorize('create_services');

        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:services,nom',
            'description' => 'required|string',
            'icon' => 'required|string',
            'tarif_consultation' => 'required|integer|min:0',
            'actif' => 'boolean',
            'ordre' => 'integer|min:1',
        ], [
            'nom.required' => 'Le nom du service est obligatoire',
            'nom.unique' => 'Ce service existe déjà',
            'description.required' => 'La description est obligatoire',
            'icon.required' => 'L\'icône est obligatoire',
            'tarif_consultation.required' => 'Le tarif de consultation est obligatoire',
            'tarif_consultation.integer' => 'Le tarif doit être un nombre',
            'tarif_consultation.min' => 'Le tarif ne peut pas être négatif',
        ]);

        // Générer slug
        $validated['slug'] = Str::slug($validated['nom']);

        $service = Service::create($validated);

        // Logger l'activité
        activity()
            ->performedOn($service)
            ->causedBy(auth()->user())
            ->log('Service créé : ' . $service->nom);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service créé avec succès');
    }

    /**
     * Afficher un service
     */
    public function show(Service $service)
    {
        $this->authorize('view_services');

        $service->load(['medecins', 'horaires', 'tarifs', 'rdvRequests' => function($query) {
            $query->latest()->limit(20);
        }]);

        return Inertia::render('Admin/Services/Show', [
            'service' => $service,
        ]);
    }

    /**
     * Afficher formulaire édition
     */
    public function edit(Service $service)
    {
        $this->authorize('edit_services');

        return Inertia::render('Admin/Services/Edit', [
            'service' => $service,
        ]);
    }

    /**
     * Mettre à jour un service
     */
    public function update(Request $request, Service $service)
    {
        $this->authorize('edit_services');

        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:services,nom,' . $service->id,
            'description' => 'required|string',
            'icon' => 'required|string',
            'tarif_consultation' => 'required|integer|min:0',
            'actif' => 'boolean',
            'ordre' => 'integer|min:1',
        ]);

        // Regénérer slug si nom changé
        if ($service->nom !== $validated['nom']) {
            $validated['slug'] = Str::slug($validated['nom']);
        }

        $service->update($validated);

        // Logger l'activité
        activity()
            ->performedOn($service)
            ->causedBy(auth()->user())
            ->log('Service modifié : ' . $service->nom);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service modifié avec succès');
    }

    /**
     * Supprimer un service (soft delete)
     */
    public function destroy(Service $service)
    {
        $this->authorize('delete_services');

        // Vérifier si service a des RDV actifs
        $rdvActifs = $service->rdvRequests()
            ->whereIn('statut', ['en_attente', 'confirme'])
            ->count();

        if ($rdvActifs > 0) {
            return back()->with('error', 'Impossible de supprimer ce service. Il a des rendez-vous actifs.');
        }

        $nomService = $service->nom;

        // Désactiver plutôt que supprimer
        $service->update(['actif' => false]);

        // Logger l'activité
        activity()
            ->performedOn($service)
            ->causedBy(auth()->user())
            ->log('Service désactivé : ' . $nomService);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service désactivé avec succès');
    }

    /**
     * Activer/Désactiver un service
     */
    public function toggleActive(Service $service)
    {
        $this->authorize('edit_services');

        $service->update(['actif' => !$service->actif]);

        $action = $service->actif ? 'activé' : 'désactivé';

        activity()
            ->performedOn($service)
            ->causedBy(auth()->user())
            ->log("Service {$action} : {$service->nom}");

        return back()->with('success', "Service {$action} avec succès");
    }
}
