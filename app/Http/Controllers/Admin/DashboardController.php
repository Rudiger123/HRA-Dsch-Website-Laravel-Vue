<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Medecin;
use App\Models\Actualite;
use App\Models\RdvRequest;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Afficher le dashboard
     */
    public function index()
    {
        $user = auth()->user();

        // Statistiques générales
        $stats = [
            'total_services' => Service::where('actif', true)->count(),
            'total_medecins' => Medecin::where('actif', true)->count(),
            'total_articles' => Actualite::count(),
        ];

        // Statistiques RDV (selon permissions)
        if ($user->can('view_all_rdv')) {
            $stats['total_rdv'] = RdvRequest::count();
            $stats['rdv_en_attente'] = RdvRequest::where('statut', 'en_attente')->count();
            $stats['rdv_confirmes'] = RdvRequest::where('statut', 'confirme')->count();
            $stats['rdv_annules'] = RdvRequest::where('statut', 'annule')->count();
        } elseif ($user->can('view_own_rdv')) {
            $stats['mes_rdv_aujourdhui'] = 0;
        }

        // Messages contact non lus
        if ($user->can('view_contacts')) {
            $stats['messages_non_lus'] = Contact::where('lu', false)->count();
        }

        // RDV du jour
        $rdvAujourdhui = [];
        if ($user->can('view_all_rdv')) {
            $rdvAujourdhui = RdvRequest::with('service')
                ->whereDate('created_at', today())
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        }

        // Derniers messages
        $derniers_messages = [];
        if ($user->can('view_contacts')) {
            $derniers_messages = Contact::orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        // Statistiques RDV par mois (graphique)
        $rdvParMois = [];
        if ($user->can('view_all_rdv')) {
            $rdvParMois = RdvRequest::select(
                    DB::raw('MONTH(created_at) as mois'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereYear('created_at', date('Y'))
                ->groupBy('mois')
                ->orderBy('mois')
                ->get()
                ->keyBy('mois')
                ->map(fn($item) => $item->total);
        }

        // Services les plus demandés
        $servicesPopulaires = [];
        if ($user->can('view_all_rdv')) {
            $servicesPopulaires = RdvRequest::select('service_id', DB::raw('COUNT(*) as total'))
                ->with('service:id,nom')
                ->groupBy('service_id')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get();
        }

        // Activité récente (audit log)
        $activiteRecente = [];
        if ($user->can('view_audit_log')) {
            $activiteRecente = \Spatie\Activitylog\Models\Activity::with('causer')
                ->latest()
                ->limit(10)
                ->get();
        }


        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'rdvAujourdhui' => $rdvAujourdhui,
            'derniers_messages' => $derniers_messages,
            'rdvParMois' => $rdvParMois,
            'servicesPopulaires' => $servicesPopulaires,
            'activiteRecente' => $activiteRecente,
        ]);
    }
}
