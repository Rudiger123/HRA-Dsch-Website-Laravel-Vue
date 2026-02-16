<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ActivityLogController extends Controller
{
    /**
     * Afficher le journal d'activité
     */
    public function index(Request $request)
    {
        $this->authorize('view_audit_log');

        $query = Activity::with(['causer', 'subject']);

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('description', 'like', "%{$search}%");
        }

        // Filtrage par utilisateur
        if ($request->has('causer_id')) {
            $query->where('causer_id', $request->causer_id);
        }

        // Filtrage par type d'action
        if ($request->has('log_name')) {
            $query->where('log_name', $request->log_name);
        }

        // Filtrage par date
        if ($request->has('date_debut') && $request->has('date_fin')) {
            $query->whereBetween('created_at', [
                $request->date_debut . ' 00:00:00',
                $request->date_fin . ' 23:59:59'
            ]);
        }

        // Pagination avec nombre d'éléments par page configurable (défaut 7)
        $perPage = $request->get('per_page', 7);
        $perPage = min($perPage, 100); // Limite max 100
        $activities = $query->latest()->paginate($perPage);

        // Liste des utilisateurs pour filtre
        $users = User::select('id', 'name')->get();

        return Inertia::render('Admin/ActivityLog/Index', [
            'activities' => [
                'data' => $activities->items(),
                'links' => $activities->linkCollection()->toArray(),
                'meta' => [
                    'current_page' => $activities->currentPage(),
                    'from' => $activities->firstItem(),
                    'last_page' => $activities->lastPage(),
                    'per_page' => $activities->perPage(),
                    'to' => $activities->lastItem(),
                    'total' => $activities->total(),
                    'path' => $activities->path(),
                ],
            ],
            'users' => $users,
            'filters' => $request->only(['search', 'causer_id', 'log_name', 'date_debut', 'date_fin', 'per_page']),
        ]);
    }

    /**
     * Afficher détails d'une activité
     */
    public function show(Activity $activity)
    {
        $activity->load(['causer', 'subject']);

        return Inertia::render('Admin/ActivityLog/Show', [
            'activity' => $activity,
        ]);
    }
}
