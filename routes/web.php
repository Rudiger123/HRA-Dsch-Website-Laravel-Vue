<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Routes Web - HRAD Dschang
|--------------------------------------------------------------------------
*/

// ==========================================
// ROUTES AUTHENTIFICATION
// ==========================================

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/admin/login', [LoginController::class, 'login'])->name('login.post');

    // Mot de passe oublié
    Route::get('/admin/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/admin/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Reset password
    Route::get('/admin/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/admin/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Logout
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================================
// ROUTES ADMIN PROTÉGÉES
// ==========================================

Route::prefix('admin')->name('admin.')->middleware(['auth', 'active'])->group(function () {

    // ==========================================
    // DASHBOARD
    // ==========================================
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('dashboard');

    // ==========================================
    // GESTION SERVICES
    // ==========================================
    Route::resource('services', App\Http\Controllers\Admin\ServiceController::class);
    Route::post('services/{service}/toggle-active', [App\Http\Controllers\Admin\ServiceController::class, 'toggleActive'])
        ->name('services.toggle-active');

    // ==========================================
    // GESTION MÉDECINS
    // ==========================================
    Route::resource('medecins', App\Http\Controllers\Admin\MedecinController::class);
    Route::delete('medecins/{medecin}/delete-photo', [App\Http\Controllers\Admin\MedecinController::class, 'deletePhoto'])
        ->name('medecins.delete-photo');

    // ==========================================
    // GESTION TARIFS
    // ==========================================
    Route::get('tarifs', [App\Http\Controllers\Admin\TarifController::class, 'index'])
        ->name('tarifs.index');
    Route::post('tarifs', [App\Http\Controllers\Admin\TarifController::class, 'store'])
        ->name('tarifs.store');
    Route::patch('tarifs/{tarif}', [App\Http\Controllers\Admin\TarifController::class, 'update'])
        ->name('tarifs.update');
    Route::delete('tarifs/{tarif}', [App\Http\Controllers\Admin\TarifController::class, 'destroy'])
        ->name('tarifs.destroy');

    // ==========================================
    // GESTION HORAIRES
    // ==========================================
    Route::get('horaires', [App\Http\Controllers\Admin\HoraireController::class, 'index'])
        ->name('horaires.index');
    Route::post('horaires', [App\Http\Controllers\Admin\HoraireController::class, 'store'])
        ->name('horaires.store');
    Route::patch('horaires/{horaire}', [App\Http\Controllers\Admin\HoraireController::class, 'update'])
        ->name('horaires.update');
    Route::delete('horaires/{horaire}', [App\Http\Controllers\Admin\HoraireController::class, 'destroy'])
        ->name('horaires.destroy');

    // ==========================================
    // GESTION ACTUALITÉS
    // ==========================================
    Route::resource('actualites', App\Http\Controllers\Admin\ActualiteController::class);
    Route::post('actualites/{actualite}/toggle-publish', [App\Http\Controllers\Admin\ActualiteController::class, 'togglePublish'])
        ->name('actualites.toggle-publish');
    Route::post('actualites/upload-image', [App\Http\Controllers\Admin\ActualiteController::class, 'uploadImage'])
        ->name('actualites.upload-image');

    // ==========================================
    // GESTION RENDEZ-VOUS
    // ==========================================
    Route::get('rdv-requests', [App\Http\Controllers\Admin\RdvRequestController::class, 'index'])
        ->name('rdv-requests.index');
    Route::get('rdv-requests/{rdvRequest}', [App\Http\Controllers\Admin\RdvRequestController::class, 'show'])
        ->name('rdv-requests.show');
    Route::patch('rdv-requests/{rdvRequest}/status', [App\Http\Controllers\Admin\RdvRequestController::class, 'updateStatus'])
        ->name('rdv-requests.update-status');
    Route::get('rdv-requests-statistics', [App\Http\Controllers\Admin\RdvRequestController::class, 'statistics'])
        ->name('rdv-requests.statistics');
    Route::get('rdv-requests-export', [App\Http\Controllers\Admin\RdvRequestController::class, 'export'])
        ->name('rdv-requests.export');

    // ==========================================
    // GESTION MESSAGES CONTACT
    // ==========================================
    Route::get('contacts', [App\Http\Controllers\Admin\ContactController::class, 'index'])
        ->name('contacts.index');
    Route::get('contacts/{contact}', [App\Http\Controllers\Admin\ContactController::class, 'show'])
        ->name('contacts.show');
    Route::post('contacts/{contact}/toggle-lu', [App\Http\Controllers\Admin\ContactController::class, 'toggleLu'])
        ->name('contacts.toggle-lu');
    Route::post('contacts/{contact}/reply', [App\Http\Controllers\Admin\ContactController::class, 'reply'])
        ->name('contacts.reply');
    Route::delete('contacts/{contact}', [App\Http\Controllers\Admin\ContactController::class, 'destroy'])
        ->name('contacts.destroy');

    // ==========================================
    // GESTION UTILISATEURS (Super Admin only)
    // ==========================================
    Route::middleware('permission:view_users')->group(function () {
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::post('users/{user}/toggle-active', [App\Http\Controllers\Admin\UserController::class, 'toggleActive'])
            ->name('users.toggle-active');
        Route::post('users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])
            ->name('users.reset-password');
    });

    // ==========================================
    // MON PROFIL
    // ==========================================
    Route::get('profile', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])
        ->name('profile.update');
    Route::post('profile/photo', [App\Http\Controllers\Admin\ProfileController::class, 'updatePhoto'])
        ->name('profile.update-photo');
    Route::delete('profile/photo', [App\Http\Controllers\Admin\ProfileController::class, 'deletePhoto'])
        ->name('profile.delete-photo');
    Route::patch('profile/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])
        ->name('profile.update-password');

    // ==========================================
    // AUDIT LOG (Super Admin)
    // ==========================================
    Route::middleware('permission:view_audit_log')->group(function () {
        Route::get('activity-log', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])
            ->name('activity-log.index');
        Route::get('activity-log/{activity}', [App\Http\Controllers\Admin\ActivityLogController::class, 'show'])
            ->name('activity-log.show');
    });
});

// ==========================================
// ROUTES PUBLIQUES (EXISTANTES)
// ==========================================

// PAGE D'ACCUEIL
use App\Models\Service;
Route::get('/', function () {
    // SEO
    SEOMeta::setTitle('HRA Dschang - Hôpital Régional Annexe de Dschang');
    SEOMeta::setDescription('Soins médicaux de qualité à Dschang. Pédiatrie, Maternité, Cardiologie, Chirurgie, Urgences 24/7. Prenez rendez-vous en ligne.');
    SEOMeta::setCanonical(url('/'));
    SEOMeta::addKeyword(['hôpital dschang', 'hra dschang', 'médecin dschang', 'santé cameroun', 'urgences dschang']);

    OpenGraph::setTitle('HRA Dschang - Votre santé, notre priorité');
    OpenGraph::setDescription('Soins médicaux de qualité à Dschang depuis 1998. 8 services médicaux, 50+ professionnels.');
    OpenGraph::setUrl(url('/'));
    OpenGraph::addImage(asset('/images/og-image.jpg'));

    JsonLd::setType('MedicalOrganization');
    JsonLd::addValue('name', 'Hôpital Régional Annexe de Dschang');
    JsonLd::addValue('address', [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Dschang',
        'addressRegion' => 'Ouest',
        'addressCountry' => 'CM'
    ]);
    JsonLd::addValue('telephone', '+237233XXXXXX');
    JsonLd::addValue('url', url('/'));

    return Inertia::render('Home', [
        'services' => Service::actif()->ordonne()->get()
    ]);
})->name('home');

// PAGE SERVICES
Route::get('/services', function () {
    SEOMeta::setTitle('Nos Services Médicaux | HRA Dschang');
    SEOMeta::setDescription('Découvrez nos 8 services médicaux : Pédiatrie, Maternité, Cardiologie, Chirurgie Générale, Urgences 24/7, Médecine Générale, Laboratoire, Radiologie.');
    SEOMeta::setCanonical(url('/services'));

    OpenGraph::setTitle('Services Médicaux - HRA Dschang');
    OpenGraph::setDescription('8 services médicaux complets avec équipe qualifiée et équipements modernes.');

    return Inertia::render('Services/Index', [
        'services' => Service::actif()->ordonne()->get()
    ]);
})->name('services');

// PAGE À PROPOS
Route::get('/a-propos', function () {
    SEOMeta::setTitle('À Propos de l\'HRA Dschang | Notre Histoire');
    SEOMeta::setDescription('Depuis 1998, l\'HRA Dschang offre des soins de qualité. Découvrez notre histoire, mission et valeurs.');
    SEOMeta::setCanonical(url('/a-propos'));

    OpenGraph::setTitle('À Propos - HRA Dschang');
    OpenGraph::setDescription('25 ans d\'excellence médicale au service de la population de Dschang.');

    return Inertia::render('About');
})->name('about');

// PAGE ÉQUIPE (liste médecins) - DOIT VENIR AVANT /services/{slug}
use App\Models\Medecin;
Route::get('/equipe', function () {
    SEOMeta::setTitle('Notre Équipe Médicale | HRA Dschang');
    SEOMeta::setDescription('Rencontrez nos médecins qualifiés et expérimentés. Plus de 50 professionnels de santé à votre service.');
    SEOMeta::setCanonical(url('/equipe'));

    OpenGraph::setTitle('Équipe Médicale - HRA Dschang');
    OpenGraph::setDescription('Médecins qualifiés et expérimentés dans toutes les spécialités.');

    $medecins = Medecin::actif()
        ->with('services')
        ->orderBy('nom')
        ->get();

    $specialites = $medecins->pluck('specialite')->unique()->values();

    return Inertia::render('Equipe/Index', [
        'medecins' => $medecins,
        'specialites' => $specialites
    ]);
})->name('equipe');

// PAGE PROFIL MÉDECIN (détail) - DOIT VENIR AVANT /services/{slug}
Route::get('/equipe/{slug}', function ($slug) {
    $medecin = Medecin::where('slug', $slug)
        ->actif()
        ->with(['services' => function ($query) {
            $query->with('horaires');
        }])
        ->firstOrFail();

    SEOMeta::setTitle('Dr. ' . $medecin->nom . ' - ' . $medecin->specialite . ' | HRA Dschang');
    SEOMeta::setDescription($medecin->bio ?? 'Médecin ' . $medecin->specialite . ' à l\'HRA Dschang. ' . $medecin->diplomes);
    SEOMeta::setCanonical(url("/equipe/{$slug}"));

    OpenGraph::setTitle('Dr. ' . $medecin->nom . ' - ' . $medecin->specialite);
    OpenGraph::setDescription($medecin->bio ?? $medecin->specialite . ' à l\'HRA Dschang');
    if ($medecin->photo) {
        OpenGraph::addImage(asset($medecin->photo));
    }

    JsonLd::setType('Person');
    JsonLd::addValue('name', 'Dr. ' . $medecin->nom);
    JsonLd::addValue('jobTitle', $medecin->specialite);
    JsonLd::addValue('worksFor', [
        '@type' => 'Organization',
        'name' => 'HRA Dschang'
    ]);

    return Inertia::render('Equipe/Show', [
        'medecin' => $medecin
    ]);
})->name('equipe.show');

// PAGE SERVICE DETAIL (show) - DOIT VENIR APRÈS /equipe/{slug}
Route::get('/services/{slug}', function ($slug) {
    $service = Service::where('slug', $slug)
        ->with(['horaires', 'tarifs', 'medecins'])
        ->firstOrFail();

    SEOMeta::setTitle($service->nom . ' | HRA Dschang');
    SEOMeta::setDescription($service->description);
    SEOMeta::setCanonical(url("/services/{$slug}"));
    SEOMeta::addKeyword([$service->nom, 'hôpital dschang', $service->nom . ' dschang']);

    OpenGraph::setTitle($service->nom . ' - HRA Dschang');
    OpenGraph::setDescription($service->description);
    OpenGraph::setUrl(url("/services/{$slug}"));

    JsonLd::setType('MedicalBusiness');
    JsonLd::addValue('name', $service->nom . ' - HRA Dschang');
    JsonLd::addValue('description', $service->description);

    return Inertia::render('Services/Show', [
        'service' => $service
    ]);
})->name('services.show');

// PAGE TARIFS
Route::get('/tarifs', function () {
    SEOMeta::setTitle('Tarifs des Consultations | HRA Dschang');
    SEOMeta::setDescription('Consultez nos tarifs transparents. Consultation générale 5000 FCFA. Paiement facilité disponible.');
    SEOMeta::setCanonical(url('/tarifs'));

    $services = Service::actif()
        ->with(['tarifs' => function($query) {
            $query->orderBy('designation');
        }])
        ->ordonne()
        ->get();

    return Inertia::render('Tarifs/Index', [
        'servicesTarifs' => $services
    ]);
})->name('tarifs');

// PAGE RENDEZ-VOUS
Route::get('/rendez-vous', function () {
    SEOMeta::setTitle('Prendre Rendez-vous en Ligne | HRA Dschang');
    SEOMeta::setDescription('Prenez rendez-vous facilement en ligne avec nos médecins. Réponse sous 24h. Urgences 24/7 disponibles.');
    SEOMeta::setCanonical(url('/rendez-vous'));

    OpenGraph::setTitle('Prendre Rendez-vous - HRA Dschang');
    OpenGraph::setDescription('Système de prise de rendez-vous en ligne simple et rapide.');

    return Inertia::render('RDV/Create', [
        'services' => Service::actif()->ordonne()->get()
    ]);
})->name('rdv');

// PAGE CONTACT
Route::get('/contact', function () {
    SEOMeta::setTitle('Nous Contacter | HRA Dschang');
    SEOMeta::setDescription('Contactez l\'HRA Dschang. Téléphone : +237 233 XX XX XX. Email : contact@hradschang.cm. Urgences 24/7 disponibles.');
    SEOMeta::setCanonical(url('/contact'));

    OpenGraph::setTitle('Contact - HRA Dschang');
    OpenGraph::setDescription('Toutes les informations pour nous contacter. Réponse rapide garantie.');

    return Inertia::render('Contact/Index');
})->name('contact');

// PAGE ACTUALITÉS (liste)
Route::get('/actualites', function (Request $request) {
    SEOMeta::setTitle('Actualités Santé & Blog | HRA Dschang');
    SEOMeta::setDescription('Conseils santé, actualités médicales et informations de l\'HRA Dschang. Restez informé sur votre santé.');
    SEOMeta::setCanonical(url('/actualites'));

    OpenGraph::setTitle('Actualités Santé - HRA Dschang');
    OpenGraph::setDescription('Blog santé avec conseils médicaux et actualités de l\'hôpital.');

    $query = \App\Models\Actualite::where('publie', true);

    // Filtre catégorie
    if ($request->has('categorie')) {
        $query->where('categorie', $request->categorie);
    }

    // Recherche
    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('titre', 'like', "%{$search}%")
              ->orWhere('extrait', 'like', "%{$search}%");
        });
    }

    $actualites = $query->orderBy('date_publication', 'desc')->paginate(9);
    $categories = \App\Models\Actualite::where('publie', true)->select('categorie')->distinct()->pluck('categorie');

    return Inertia::render('Actualites/Index', [
        'actualites' => $actualites,
        'categories' => $categories,
        'filtreCategorie' => $request->categorie,
        'searchQuery' => $request->search
    ]);
})->name('actualites.index');

// PAGE DÉTAIL ACTUALITÉ
Route::get('/actualites/{slug}', function ($slug) {
    $actualite = \App\Models\Actualite::where('slug', $slug)
                           ->where('publie', true)
                           ->firstOrFail();

    // Incrémenter vues
    $actualite->incrementVues();

    // Articles similaires
    $similaires = \App\Models\Actualite::where('publie', true)
                            ->where('categorie', $actualite->categorie)
                            ->where('id', '!=', $actualite->id)
                            ->orderBy('date_publication', 'desc')
                            ->limit(3)
                            ->get();

    SEOMeta::setTitle($actualite->titre . ' | HRA Dschang');
    SEOMeta::setDescription($actualite->extrait);
    SEOMeta::setCanonical(url("/actualites/{$slug}"));
    SEOMeta::addKeyword([$actualite->categorie, 'santé', 'hôpital dschang']);

    OpenGraph::setTitle($actualite->titre);
    OpenGraph::setDescription($actualite->extrait);
    OpenGraph::setUrl(url("/actualites/{$slug}"));
    OpenGraph::setType('article');
    if ($actualite->image) {
        OpenGraph::addImage(asset($actualite->image));
    }

    JsonLd::setType('Article');
    JsonLd::addValue('headline', $actualite->titre);
    JsonLd::addValue('description', $actualite->extrait);
    JsonLd::addValue('author', [
        '@type' => 'Person',
        'name' => $actualite->auteur
    ]);
    JsonLd::addValue('datePublished', $actualite->date_publication->toIso8601String());

    return Inertia::render('Actualites/Show', [
        'actualite' => $actualite,
        'similaires' => $similaires
    ]);
})->name('actualites.show');

// PAGE FAQ
Route::get('/faq', function () {
    SEOMeta::setTitle('Questions Fréquentes (FAQ) | HRA Dschang');
    SEOMeta::setDescription('Trouvez les réponses à vos questions sur les consultations, rendez-vous, tarifs et services de l\'HRA Dschang.');
    SEOMeta::setCanonical(url('/faq'));

    return Inertia::render('FAQ');
})->name('faq');
// PAGES LÉGALES
// Mentions Légales
Route::get('/mentions-legales', function () {
    SEOMeta::setTitle('Mentions Légales | HRA Dschang');
    SEOMeta::setDescription('Mentions légales et informations réglementaires de l\'HRA Dschang.');
    SEOMeta::setCanonical(url('/mentions-legales'));
    SEOMeta::setRobots('noindex, follow');

    return Inertia::render('Legal/MentionsLegales');
})->name('legal.mentions');

// Politique de Confidentialité
Route::get('/confidentialite', function () {
    SEOMeta::setTitle('Politique de Confidentialité | HRA Dschang');
    SEOMeta::setDescription('Comment nous protégeons vos données personnelles et médicales.');
    SEOMeta::setCanonical(url('/confidentialite'));
    SEOMeta::setRobots('noindex, follow');

    return Inertia::render('Legal/Confidentialite');
})->name('legal.confidentialite');

// Conditions Générales d'Utilisation
Route::get('/cgu', function () {
    SEOMeta::setTitle('Conditions Générales d\'Utilisation | HRA Dschang');
    SEOMeta::setDescription('Conditions d\'utilisation du site web de l\'HRA Dschang.');
    SEOMeta::setCanonical(url('/cgu'));
    SEOMeta::setRobots('noindex, follow');

    return Inertia::render('Legal/CGU');
})->name('legal.cgu');
