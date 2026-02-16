<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Actualite;
use Illuminate\Http\Request;

class ActualiteController extends Controller
{
    /**
     * Liste toutes les actualités publiées
     */
    public function index(Request $request)
    {
        $query = Actualite::publie();

        // Filtrer par catégorie si présent
        if ($request->has('categorie')) {
            $query->categorie($request->categorie);
        }

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('extrait', 'like', "%{$search}%");
            });
        }

        $actualites = $query->paginate(9);

        return response()->json($actualites);
    }

    /**
     * Affiche une actualité spécifique
     */
    public function show($slug)
    {
        $actualite = Actualite::where('slug', $slug)
                               ->where('publie', true)
                               ->firstOrFail();

        // Incrémenter compteur de vues
        $actualite->incrementVues();

        // Articles similaires (même catégorie)
        $similaires = Actualite::publie()
                                ->categorie($actualite->categorie)
                                ->where('id', '!=', $actualite->id)
                                ->limit(3)
                                ->get();

        return response()->json([
            'actualite' => $actualite,
            'similaires' => $similaires
        ]);
    }

    /**
     * Liste des catégories disponibles
     */
    public function categories()
    {
        $categories = Actualite::where('publie', true)
                                ->select('categorie')
                                ->distinct()
                                ->pluck('categorie');

        return response()->json($categories);
    }
}

