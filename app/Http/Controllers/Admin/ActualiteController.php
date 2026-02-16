<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actualite;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ActualiteController extends Controller
{
    /**
     * Afficher liste des actualités
     */
    public function index(Request $request)
    {
        $this->authorize('view_actualites');
        $query = Actualite::query();

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('extrait', 'like', "%{$search}%")
                  ->orWhere('auteur', 'like', "%{$search}%");
            });
        }

        // Filtrage par catégorie
        if ($request->has('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        // Filtrage par statut de publication
        if ($request->has('publie')) {
            $query->where('publie', $request->publie);
        }

        // Tri
        $sortField = $request->get('sort', 'date_publication');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $actualites = $query->paginate(15);

        // Liste des catégories pour filtre
        $categories = Actualite::select('categorie')
            ->distinct()
            ->pluck('categorie');

        return Inertia::render('Admin/Actualites/Index', [
            'actualites' => $actualites,
            'categories' => $categories,
            'filters' => $request->only(['search', 'categorie', 'publie', 'sort', 'direction']),
        ]);
    }

    /**
     * Afficher formulaire création
     */
    public function create()
    {
        $this->authorize('create_actualites');

        $categories = [
            'Événements',
            'Nutrition',
            'Prévention',
            'Sport & Santé',
            'Maternité',
            'Santé Mentale',
            'Pneumologie',
            'Cardiologie',
        ];

        return Inertia::render('Admin/Actualites/Create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Créer une actualité
     */
    public function store(Request $request)
    {
        $this->authorize('create_actualites');

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'extrait' => 'required|string|max:500',
            'contenu' => 'required|string|min:100',
            'categorie' => 'required|string',
            'auteur' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'publie' => 'boolean',
            'date_publication' => 'nullable|date',
        ], [
            'titre.required' => 'Le titre est obligatoire',
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères',
            'extrait.required' => 'L\'extrait est obligatoire',
            'extrait.max' => 'L\'extrait ne peut pas dépasser 500 caractères',
            'contenu.required' => 'Le contenu est obligatoire',
            'contenu.min' => 'Le contenu doit contenir au moins 100 caractères',
            'categorie.required' => 'La catégorie est obligatoire',
            'auteur.required' => 'L\'auteur est obligatoire',
            'image.image' => 'Le fichier doit être une image',
            'image.mimes' => 'Format autorisé : JPEG, JPG, PNG, WEBP',
            'image.max' => 'Taille maximale : 2MB',
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $dir = public_path('images/actualites');
            if (!is_dir($dir)) mkdir($dir, 0755, true);

            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->move($dir, $filename);
            $validated['image'] = '/images/actualites/' . $filename;
        }

        // Générer slug
        $validated['slug'] = Str::slug($validated['titre']);

        // Date de publication
        if (!isset($validated['date_publication']) || empty($validated['date_publication'])) {
            $validated['date_publication'] = now();
        }

        // Créer actualité
        $actualite = Actualite::create($validated);

        // Logger l'activité
        activity()
            ->performedOn($actualite)
            ->causedBy(auth()->user())
            ->log('Article créé : ' . $actualite->titre);

        return redirect()->route('admin.actualites.index')
            ->with('success', 'Article créé avec succès');
    }

    /**
     * Afficher une actualité
     */
    public function show(Actualite $actualite)
    {
        $this->authorize('view_actualites');

        return Inertia::render('Admin/Actualites/Show', [
            'actualite' => $actualite,
        ]);
    }

    /**
     * Afficher formulaire édition
     */
    public function edit(Actualite $actualite)
    {
        $this->authorize('edit_actualites');

        $categories = [
            'Événements',
            'Nutrition',
            'Prévention',
            'Sport & Santé',
            'Maternité',
            'Santé Mentale',
            'Pneumologie',
            'Cardiologie',
        ];

        return Inertia::render('Admin/Actualites/Edit', [
            'actualite' => $actualite,
            'categories' => $categories,
        ]);
    }

    /**
     * Mettre à jour une actualité
     */
    public function update(Request $request, Actualite $actualite)
    {
        $this->authorize('edit_actualites');

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'extrait' => 'required|string|max:500',
            'contenu' => 'required|string|min:100',
            'categorie' => 'required|string',
            'auteur' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'publie' => 'boolean',
            'date_publication' => 'nullable|date',
        ]);

        // Upload nouvelle image
        if ($request->hasFile('image')) {
            // Supprimer ancienne image
            if ($actualite->image && file_exists(public_path($actualite->image))) {
                unlink(public_path($actualite->image));
            }

            $image = $request->file('image');
            $dir = public_path('images/actualites');
            if (!is_dir($dir)) mkdir($dir, 0755, true);

            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->move($dir, $filename);
            $validated['image'] = '/images/actualites/' . $filename;
        }

        // Regénérer slug si titre changé
        if ($actualite->titre !== $validated['titre']) {
            $validated['slug'] = Str::slug($validated['titre']);
        }

        $actualite->update($validated);

        // Logger l'activité
        activity()
            ->performedOn($actualite)
            ->causedBy(auth()->user())
            ->log('Article modifié : ' . $actualite->titre);

        return redirect()->route('admin.actualites.index')
            ->with('success', 'Article modifié avec succès');
    }

    /**
     * Supprimer une actualité (soft delete)
     */
    public function destroy(Actualite $actualite)
    {
        $titreActualite = $actualite->titre;

        // Supprimer image
        if ($actualite->image && file_exists(public_path($actualite->image))) {
            unlink(public_path($actualite->image));
        }

        $actualite->delete();

        // Logger l'activité
        activity()
            ->performedOn($actualite)
            ->causedBy(auth()->user())
            ->log('Article supprimé : ' . $titreActualite);

        return redirect()->route('admin.actualites.index')
            ->with('success', 'Article supprimé avec succès');
    }

    /**
     * Publier/Dépublier une actualité
     */
    public function togglePublish(Actualite $actualite)
    {
        $this->authorize('publish_actualites');

        $actualite->update(['publie' => !$actualite->publie]);

        $action = $actualite->publie ? 'publié' : 'dépublié';

        activity()
            ->performedOn($actualite)
            ->causedBy(auth()->user())
            ->log("Article {$action} : {$actualite->titre}");

        return back()->with('success', "Article {$action} avec succès");
    }

    /**
     * Upload image dans le contenu (pour WYSIWYG)
     */
    public function uploadImage(Request $request)
    {
        $this->authorize('create_actualites');

        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $dir = public_path('images/actualites/content');
            if (!is_dir($dir)) mkdir($dir, 0755, true);

            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->move($dir, $filename);

            return response()->json([
                'success' => true,
                'url' => asset('/images/actualites/content/' . $filename),
            ]);
        }

        return response()->json(['success' => false], 400);
    }
}
