<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Horaire;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HoraireController extends Controller
{
    /**
     * Afficher liste des horaires
     */
    public function index(Request $request)
    {
        $this->authorize('manage_horaires');
        $query = Horaire::with('service:id,nom');

        // Filtrage par service
        if ($request->has('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        $horaires = $query->orderBy('service_id')
            ->orderByRaw("FIELD(jour_semaine, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche')")
            ->get();

        $services = Service::where('actif', true)->orderBy('ordre')->get(['id', 'nom']);

        return Inertia::render('Admin/Horaires/Index', [
            'horaires' => $horaires,
            'services' => $services,
            'filters' => $request->only(['service_id']),
        ]);
    }

    /**
     * Créer un horaire
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'jour_semaine' => 'required|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi,Dimanche',
            'ouverture' => 'required|date_format:H:i',
            'fermeture' => 'required|date_format:H:i|after:ouverture',
            'note' => 'nullable|string|max:255',
        ], [
            'service_id.required' => 'Le service est obligatoire',
            'jour_semaine.required' => 'Le jour est obligatoire',
            'ouverture.required' => 'L\'heure d\'ouverture est obligatoire',
            'ouverture.date_format' => 'Format d\'heure invalide (HH:MM)',
            'fermeture.required' => 'L\'heure de fermeture est obligatoire',
            'fermeture.after' => 'L\'heure de fermeture doit être après l\'ouverture',
        ]);

        // Vérifier si horaire existe déjà pour ce service et jour
        $existe = Horaire::where('service_id', $validated['service_id'])
            ->where('jour_semaine', $validated['jour_semaine'])
            ->exists();

        if ($existe) {
            return back()->withErrors([
                'jour_semaine' => 'Un horaire existe déjà pour ce service et ce jour'
            ]);
        }

        $horaire = Horaire::create($validated);

        activity()
            ->performedOn($horaire)
            ->causedBy(auth()->user())
            ->log('Horaire créé : ' . $horaire->jour_semaine);

        return back()->with('success', 'Horaire créé avec succès');
    }

    /**
     * Mettre à jour un horaire
     */
    public function update(Request $request, Horaire $horaire)
    {
        $validated = $request->validate([
            'ouverture' => 'required|date_format:H:i',
            'fermeture' => 'required|date_format:H:i|after:ouverture',
            'note' => 'nullable|string|max:255',
        ]);

        $horaire->update($validated);

        activity()
            ->performedOn($horaire)
            ->causedBy(auth()->user())
            ->log('Horaire modifié : ' . $horaire->jour_semaine);

        return back()->with('success', 'Horaire modifié avec succès');
    }

    /**
     * Supprimer un horaire
     */
    public function destroy(Horaire $horaire)
    {
        $jour = $horaire->jour_semaine;

        $horaire->delete();

        activity()
            ->causedBy(auth()->user())
            ->log('Horaire supprimé : ' . $jour);

        return back()->with('success', 'Horaire supprimé avec succès');
    }
}
