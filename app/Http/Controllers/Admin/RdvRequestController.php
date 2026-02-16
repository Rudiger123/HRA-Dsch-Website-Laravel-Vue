<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RdvRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class RdvRequestController extends Controller
{
    /**
     * Afficher liste des demandes RDV
     */
    public function index(Request $request)
    {
        // Vérifier les permissions
        if (!auth()->user()->hasAnyPermission(['view_all_rdv', 'view_own_rdv'])) {
            abort(403);
        }

        $user = auth()->user();

        $query = RdvRequest::with('service:id,nom');

        // Si médecin, voir seulement ses RDV
        if ($user->can('view_own_rdv') && !$user->can('view_all_rdv')) {
            // TODO: Filtrer par médecin (nécessite relation medecin_id dans rdv_requests)
        }

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom_patient', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%")
                  ->orWhere('motif', 'like', "%{$search}%");
            });
        }

        // Filtrage par service
        if ($request->has('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        // Filtrage par statut
        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtrage par date
        if ($request->has('date_debut') && $request->has('date_fin')) {
            $query->whereBetween('created_at', [
                $request->date_debut . ' 00:00:00',
                $request->date_fin . ' 23:59:59'
            ]);
        }

        // Tri
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $rdvRequests = $query->paginate(20);

        // Services pour filtre
        $services = Service::where('actif', true)->orderBy('ordre')->get(['id', 'nom']);

        // Statistiques
        $stats = [
            'total' => RdvRequest::count(),
            'en_attente' => RdvRequest::where('statut', 'en_attente')->count(),
            'confirmes' => RdvRequest::where('statut', 'confirme')->count(),
            'annules' => RdvRequest::where('statut', 'annule')->count(),
        ];

        return Inertia::render('Admin/RDV/Index', [
            'rdvRequests' => $rdvRequests,
            'services' => $services,
            'stats' => $stats,
            'filters' => $request->only(['search', 'service_id', 'statut', 'date_debut', 'date_fin', 'sort', 'direction']),
        ]);
    }

    /**
     * Afficher détails d'une demande RDV
     */
    public function show(RdvRequest $rdvRequest)
    {
        $rdvRequest->load('service');

        // Historique du patient (autres RDV)
        $historique = RdvRequest::where('telephone', $rdvRequest->telephone)
            ->where('id', '!=', $rdvRequest->id)
            ->with('service:id,nom')
            ->latest()
            ->limit(10)
            ->get();

        return Inertia::render('Admin/RDV/Show', [
            'rdvRequest' => $rdvRequest,
            'historique' => $historique,
        ]);
    }

    /**
     * Mettre à jour le statut d'une demande RDV
     */
    public function updateStatus(Request $request, RdvRequest $rdvRequest)
    {        $this->authorize('manage_rdv');        $this->authorize('manage_rdv');

        $validated = $request->validate([
            'statut' => 'required|in:en_attente,confirme,annule',
            'note' => 'nullable|string|max:500',
        ]);

        $ancienStatut = $rdvRequest->statut;

        $rdvRequest->update($validated);

        // Logger l'activité
        activity()
            ->performedOn($rdvRequest)
            ->causedBy(auth()->user())
            ->withProperties([
                'ancien_statut' => $ancienStatut,
                'nouveau_statut' => $validated['statut'],
            ])
            ->log("RDV #{$rdvRequest->id} : {$ancienStatut} → {$validated['statut']}");

        return back()->with('success', 'Statut du rendez-vous mis à jour');
    }

    /**
     * Exporter les RDV en Excel
     */
    public function export(Request $request)
    {
        $this->authorize('view_all_rdv');

        return back()->with('info', 'Export Excel à implémenter');
    }

    /**
     * Statistiques détaillées
     */
    public function statistics()
    {
        $this->authorize('view_full_dashboard');

        // RDV par mois (12 derniers mois)
        $rdvParMois = RdvRequest::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as mois'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        // RDV par service
        $rdvParService = RdvRequest::select('service_id', DB::raw('COUNT(*) as total'))
            ->with('service:id,nom')
            ->groupBy('service_id')
            ->orderBy('total', 'desc')
            ->get();

        // Taux de confirmation
        $totalRdv = RdvRequest::count();
        $rdvConfirmes = RdvRequest::where('statut', 'confirme')->count();
        $tauxConfirmation = $totalRdv > 0 ? round(($rdvConfirmes / $totalRdv) * 100, 2) : 0;

        // RDV par jour de la semaine
        $rdvParJour = RdvRequest::select(
                DB::raw('DAYOFWEEK(created_at) as jour'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('jour')
            ->orderBy('jour')
            ->get();

        return Inertia::render('Admin/RDV/Statistics', [
            'rdvParMois' => $rdvParMois,
            'rdvParService' => $rdvParService,
            'tauxConfirmation' => $tauxConfirmation,
            'rdvParJour' => $rdvParJour,
        ]);
    }
}
