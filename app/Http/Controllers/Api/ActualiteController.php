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

        // Ajouter les attributs calculés pour chaque actualité
        $actualites->getCollection()->transform(function($actualite) {
            return [
                'id' => $actualite->id,
                'titre' => $actualite->titre,
                'slug' => $actualite->slug,
                'extrait' => $actualite->extrait,
                'image' => $actualite->image,
                'video' => $actualite->video,
                'video_type' => $actualite->video_type,
                'categorie' => $actualite->categorie,
                'auteur' => $actualite->auteur,
                'date_publication' => $actualite->date_publication,
                'date_formattee' => $actualite->date_formattee,
                'vues' => $actualite->vues,
                'likes_count' => $actualite->likes_count,
                'temps_lecture' => $actualite->temps_lecture,
            ];
        });

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
                                ->get()
                                ->map(function($a) {
                                    return [
                                        'id' => $a->id,
                                        'titre' => $a->titre,
                                        'slug' => $a->slug,
                                        'extrait' => $a->extrait,
                                        'image' => $a->image,
                                        'categorie' => $a->categorie,
                                        'date_publication' => $a->date_publication,
                                        'date_formattee' => $a->date_formattee,
                                        'vues' => $a->vues,
                                        'likes_count' => $a->likes_count,
                                        'temps_lecture' => $a->temps_lecture,
                                    ];
                                });

        // Statistiques de likes
        $likeStats = [
            'total' => $actualite->likes_count,
            'by_type' => [
                'like' => $actualite->likesByType('like'),
                'love' => $actualite->likesByType('love'),
                'wow' => $actualite->likesByType('wow'),
                'sad' => $actualite->likesByType('sad'),
                'angry' => $actualite->likesByType('angry'),
            ]
        ];

        return response()->json([
            'actualite' => [
                'id' => $actualite->id,
                'titre' => $actualite->titre,
                'slug' => $actualite->slug,
                'extrait' => $actualite->extrait,
                'contenu' => $actualite->contenu,
                'image' => $actualite->image,
                'video' => $actualite->video,
                'video_type' => $actualite->video_type,
                'categorie' => $actualite->categorie,
                'auteur' => $actualite->auteur,
                'date_publication' => $actualite->date_publication,
                'date_formattee' => $actualite->date_formattee,
                'vues' => $actualite->vues,
                'likes_count' => $actualite->likes_count,
                'temps_lecture' => $actualite->temps_lecture,
            ],
            'likes_stats' => $likeStats,
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

