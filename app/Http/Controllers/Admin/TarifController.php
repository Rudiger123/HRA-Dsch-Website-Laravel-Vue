<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tarif;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TarifController extends Controller
{
    /**
     * Afficher liste des tarifs
     */
    public function index(Request $request)
    {
        $this->authorize('manage_tarifs');
        $query = Tarif::with('service:id,nom');

        // Filtrage par service
        if ($request->has('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        $tarifs = $query->orderBy('service_id')->get();

        $services = Service::where('actif', true)->orderBy('ordre')->get(['id', 'nom']);

        return Inertia::render('Admin/Tarifs/Index', [
            'tarifs' => $tarifs,
            'services' => $services,
            'filters' => $request->only(['service_id']),
        ]);
    }

    /**
     * Créer un tarif
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'designation' => 'required|string|max:255',
            'montant' => 'required|integer|min:0',
            'type_patient' => 'required|in:normal,etudiant,urgence',
            'details' => 'nullable|string',
        ], [
            'service_id.required' => 'Le service est obligatoire',
            'designation.required' => 'La désignation est obligatoire',
            'montant.required' => 'Le montant est obligatoire',
            'montant.integer' => 'Le montant doit être un nombre',
            'montant.min' => 'Le montant ne peut pas être négatif',
            'type_patient.required' => 'Le type de patient est obligatoire',
        ]);

        $tarif = Tarif::create($validated);

        activity()
            ->performedOn($tarif)
            ->causedBy(auth()->user())
            ->log('Tarif créé : ' . $tarif->designation);

        return back()->with('success', 'Tarif créé avec succès');
    }

    /**
     * Mettre à jour un tarif
     */
    public function update(Request $request, Tarif $tarif)
    {
        $validated = $request->validate([
            'designation' => 'required|string|max:255',
            'montant' => 'required|integer|min:0',
            'type_patient' => 'required|in:normal,etudiant,urgence',
            'details' => 'nullable|string',
        ]);

        $tarif->update($validated);

        activity()
            ->performedOn($tarif)
            ->causedBy(auth()->user())
            ->log('Tarif modifié : ' . $tarif->designation);

        return back()->with('success', 'Tarif modifié avec succès');
    }

    /**
     * Supprimer un tarif
     */
    public function destroy(Tarif $tarif)
    {
        $designation = $tarif->designation;

        $tarif->delete();

        activity()
            ->causedBy(auth()->user())
            ->log('Tarif supprimé : ' . $designation);

        return back()->with('success', 'Tarif supprimé avec succès');
    }
}
