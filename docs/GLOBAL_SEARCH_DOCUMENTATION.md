# Documentation - Recherche Globale Admin

## Vue d'ensemble

La recherche globale est une fonctionnalité de recherche en temps réel qui permet aux administrateurs de chercher rapidement dans tous les modules du dashboard (Services, Médecins, Actualités, Rendez-vous, Utilisateurs).

## Fichiers créés/modifiés

### Fichiers créés :
1. **[resources/js/Components/Admin/GlobalSearch.vue](resources/js/Components/Admin/GlobalSearch.vue)** - Composant principal de recherche
2. **[resources/js/Components/Admin/SearchResultItem.vue](resources/js/Components/Admin/SearchResultItem.vue)** - Composant d'affichage d'un résultat
3. **[app/Http/Controllers/Api/SearchController.php](app/Http/Controllers/Api/SearchController.php)** - Contrôleur API de recherche

### Fichiers modifiés :
1. **[resources/js/Layouts/AdminLayout.vue](resources/js/Layouts/AdminLayout.vue)** - Intégration du composant GlobalSearch dans le header
2. **[resources/js/Pages/Admin/ActivityLog/Index.vue](resources/js/Pages/Admin/ActivityLog/Index.vue)** - Ajout de l'import ziggy-js
3. **[routes/api.php](routes/api.php)** - Ajout de la route de recherche

## Fonctionnalités

### 1. Barre de recherche
- **Position** : Header du dashboard, à côté des notifications
- **Activation** : 
  - Clic sur le bouton de recherche (mode bureau)
  - Raccourci clavier `Cmd+K` (Mac) ou `Ctrl+K` (Windows/Linux)
- **Design** : Style épuré avec icône loupe, fond slate-100, bordures arrondies

### 2. Modal de recherche
- **Overlay fullscreen** avec fond blur et backdrop semi-transparent
- **Focus automatique** sur l'input de recherche à l'ouverture
- **Navigation au clavier** :
  - ⬆️ / ⬇️ : Naviguer entre les résultats
  - Entrée : Sélectionner le résultat
  - Échap : Fermer le modal

### 3. Catégories de résultats

#### Services médicaux
- Recherche dans : `nom`, `description`
- Permission requise : `view_services`
- Limite : 5 résultats

#### Médecins
- Recherche dans : `nom`, `specialite`, relations `services`
- Permission requise : `view_medecins`
- Limite : 5 résultats

#### Actualités
- Recherche dans : `titre`, `contenu`, `extrait`
- Filtre : uniquement articles publiés (`publie = true`)
- Permission requise : `view_actualites`
- Limite : 5 résultats

#### Rendez-vous
- Recherche dans : `nom_patient`, `telephone`, `motif`
- Permission requise : `view_all_rdv` ou `view_own_rdv`
- Limite : 5 résultats

#### Utilisateurs
- Recherche dans : `name`, `email`
- Permission requise : `view_users` (généralement super_admin/admin)
- Limite : 5 résultats

### 4. Fonctionnalités avancées

#### Debounce de recherche
- Délai de 300ms après la saisie pour éviter trop d'appels API
- Amélioré les performances sur les recherches longues

#### Historique de recherches
- Sauvegarde des 5 dernières recherches dans `localStorage`
- Affichage dans le modal lors d'une recherche vide
- Clic pour reprendre la recherche précédente

#### Loading et états d'erreur
- Spinner animé pendant la recherche
- Gestion des erreurs réseau
- Message vide state cohérent

#### Permissions
- Respecte strictement les permissions de l'utilisateur connecté
- Les catégories non autorisées ne s'affichent pas

## Architecture technique

### Frontend (Vue 3)

**GlobalSearch.vue** :
```javascript
- Gestion de l'état (modal ouvert/fermé, query, résultats)
- Appels API axios à /api/search/global
- Écoute globale des raccourcis clavier
- Gestion du localStorage pour l'historique
- Transitions fluides et animations
```

**SearchResultItem.vue** :
```javascript
- Composant présentatif pour un résultat
- Icône dynamique selon le type (Hospital, Stethoscope, etc.)
- Badge de catégorie avec couleur adaptée
- État sélectionné avec highlight visuel
```

### Backend (Laravel)

**SearchController.php** :
```php
POST /api/search/global

Validation :
- query : string, min:2, max:100

Logique :
- Authentification requise (middleware 'auth')
- Vérification des permissions de l'utilisateur
- Recherche multi-table avec wildcards
- Limitation à 5 résultats par catégorie
- Formatage en JSON avec structure claire
```

## Utilisation

### Pour les administrateurs

1. **Ouvrir la recherche** :
   - Double-clic sur la barre de recherche
   - Ou appuyez sur `Cmd+K` / `Ctrl+K`

2. **Saisir une recherche** :
   - Minimum 2 caractères
   - Recherche en temps réel (debounce 300ms)
   - Historique visible pour les recherches vides

3. **Naviguer et sélectionner** :
   - Flèches haut/bas pour naviguer
   - Entrée pour ouvrir le résultat sélectionné
   - Clic souris pour sélectionner directement

4. **Fermer** :
   - Pressing `Échap`
   - Clic en dehors du modal
   - Sélection d'un résultat

### Exemples de recherches

- Search "Cardio" → Affichera Services contenant "Cardio" et Médecins avec spécialité Cardiologie
- Search "Jean" → Affichera les Médecins et Utilisateurs nommés Jean
- Search "rendez-vous" → Affichera les Rendez-vous contenant ce terme
- Search "2025" → Affichera les Rendez-vous et Actualités contenant "2025"

## Configuration

### API Route

Route enregistrée dans `routes/api.php` :
```php
Route::middleware('auth')->post('/search/global', [SearchController::class, 'global'])->name('search.global');
```

- Endpoint : `POST /api/search/global`
- Authentification : Requise
- Payload : `{ "query": "string" }`

### Import du composant

Dans `AdminLayout.vue` :
```vue
<script setup>
import GlobalSearch from '@/Components/Admin/GlobalSearch.vue'
</script>

<template>
  <!-- Dans le header -->
  <GlobalSearch />
</template>
```

## Performance

- **Debounce** : 300ms pour limiter les appels API
- **Limite** : 5 résultats par catégorie
- **Validation** : Min 2 caractères requis
- **Cache** : Historique localisé en localStorage
- **Permissions** : Vérification côté serveur

## Security

- ✅ Authentification requise
- ✅ Vérification des permissions par utilisateur
- ✅ Validation de l'input côté serveur
- ✅ Filtre des ressources publiées/actives
- ✅ Pas d'exposition de données sensibles

## Limitations et futures améliorations

### Limitations actuelles
- Maximum 5 résultats par catégorie
- Pas de filtrage avancé
- Pas de sauvegarde serveur des recherches

### Possibles améliorations
- Faceted search (filtrer par catégorie)
- Historique personnalisé par utilisateur
- Résultats proposés/populaires
- Recherche avec opérateurs booléens
- Analytics des recherches

## Troubleshooting

### La recherche ne retourne rien
- Vérifier les permissions de l'utilisateur
- S'assurer que les données sont marquées comme actives/publiées
- Vérifier la syntaxe dans l'API (min 2 caractères)

### Le modal ne s'ouvre pas
- Vérifier le raccourci clavier (`Cmd+K` / `Ctrl+K`)
- Vérifier la console pour les erreurs JavaScript
- S'assurer que axios est bien chargé

### Les résultats ne s'affichent pas
- Vérifier les permissions dans spatie/laravel-permission
- Vérifier l'état publie/actif des ressources
- Vérifier l'endpoint API en Network tab

## Support et documentations liées

- Framework frontend : Vue 3
- Framework backend : Laravel 12
- ORM : Eloquent
- Library UI : lucide-vue-next
- Authentification : Inertia.js
- Permissions : Spatie Laravel Permission
