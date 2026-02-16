<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Service, Medecin, Actualite, RdvRequest, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    /**
     * Recherche globale sur les ressources du système
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function global(Request $request)
    {
        // Valider la requête
        $validated = $request->validate([
            'query' => 'required|string|min:2|max:100',
        ]);

        $query = trim($validated['query']);
        $user = Auth::user();
        $limit = 5; // Limite de résultats par catégorie

        $results = [
            'services' => [],
            'medecins' => [],
            'actualites' => [],
            'rdv' => [],
            'users' => [],
        ];

        /**
         * SERVICES
         * Chercher dans : nom, description
         */
        if ($user && $user->can('view_services')) {
            $results['services'] = Service::where('actif', true)
                ->where(function ($q) use ($query) {
                    $q->where('nom', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                })
                ->limit($limit)
                ->get()
                ->map(function ($service) {
                    return [
                        'id' => $service->id,
                        'title' => $service->nom,
                        'subtitle' => Str::limit($service->description, 60),
                        'url' => route('admin.services.show', $service->id),
                        'type' => 'service',
                    ];
                })
                ->toArray();
        }

        /**
         * MÉDECINS
         * Chercher dans : nom, spécialité
         */
        if ($user && $user->can('view_medecins')) {
            $results['medecins'] = Medecin::where('actif', true)
                ->where(function ($q) use ($query) {
                    $q->where('nom', 'like', "%{$query}%")
                        ->orWhere('specialite', 'like', "%{$query}%")
                        ->orWhereHas('services', function ($sq) use ($query) {
                            $sq->where('nom', 'like', "%{$query}%");
                        });
                })
                ->limit($limit)
                ->get()
                ->map(function ($medecin) {
                    $specialites = $medecin->services?->pluck('nom')->implode(', ') ?? $medecin->specialite ?? 'Non spécifié';
                    return [
                        'id' => $medecin->id,
                        'title' => $medecin->nom,
                        'subtitle' => $specialites,
                        'url' => route('admin.medecins.show', $medecin->id),
                        'type' => 'medecin',
                    ];
                })
                ->toArray();
        }

        /**
         * ACTUALITÉS
         * Chercher dans : titre, contenu, extrait
         */
        if ($user && $user->can('view_actualites')) {
            $results['actualites'] = Actualite::where('publie', true)
                ->where(function ($q) use ($query) {
                    $q->where('titre', 'like', "%{$query}%")
                        ->orWhere('contenu', 'like', "%{$query}%")
                        ->orWhere('extrait', 'like', "%{$query}%");
                })
                ->limit($limit)
                ->get()
                ->map(function ($actualite) {
                    $subtitle = $actualite->extrait
                        ? Str::limit($actualite->extrait, 60)
                        : Str::limit(strip_tags($actualite->contenu), 60);
                    return [
                        'id' => $actualite->id,
                        'title' => $actualite->titre,
                        'subtitle' => $subtitle,
                        'url' => route('admin.actualites.show', $actualite->id),
                        'type' => 'actualite',
                    ];
                })
                ->toArray();
        }

        /**
         * RENDEZ-VOUS
         * Chercher dans : nom_patient, telephone, motif
         * Permission : view_all_rdv ou view_own_rdv
         */
        if ($user && ($user->can('view_all_rdv') || $user->can('view_own_rdv'))) {
            $query_rdv = RdvRequest::where(function ($q) use ($query) {
                $q->where('nom_patient', 'like', "%{$query}%")
                    ->orWhere('telephone', 'like', "%{$query}%")
                    ->orWhere('motif', 'like', "%{$query}%");
            });

            $results['rdv'] = $query_rdv->limit($limit)
                ->get()
                ->map(function ($rdv) {
                    $date = $rdv->date_souhaitee
                        ? \Carbon\Carbon::parse($rdv->date_souhaitee)->format('d/m/Y H:i')
                        : 'À définir';
                    return [
                        'id' => $rdv->id,
                        'title' => $rdv->nom_patient,
                        'subtitle' => "Prévu le " . $date,
                        'url' => route('admin.rdv-requests.show', $rdv->id),
                        'type' => 'rdv',
                    ];
                })
                ->toArray();
        }

        /**
         * UTILISATEURS
         * Chercher dans : name, email
         * Permission : view_users (généralement super_admin/admin)
         */
        if ($user && $user->can('view_users')) {
            $results['users'] = User::where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%");
            })
                ->limit($limit)
                ->get()
                ->map(function ($u) {
                    return [
                        'id' => $u->id,
                        'title' => $u->name,
                        'subtitle' => $u->email,
                        'url' => route('admin.users.show', $u->id),
                        'type' => 'user',
                    ];
                })
                ->toArray();
        }

        return response()->json($results);
    }
}
