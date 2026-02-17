# Mise à Jour Système d'Actualités - Vidéos et Réactions

## Vue d'ensemble
Cette mise à jour ajoute les fonctionnalités suivantes au système d'actualités:
- Support complet des vidéos (upload local, YouTube, Vimeo)
- Système de réactions/likes (5 types: like, love, wow, sad, angry)
- Adaptation du design pour les cas sans vidéo/image
- API complète pour gérer les réactions

## Changements Apportés

### 1. Base de Données

#### Migrations Créées:
- `2026_02_17_170543_add_video_to_actualites_table.php`
  - Ajoute: `video` (chemin/URL vidéo)
  - Ajoute: `video_type` (upload, youtube, vimeo)
  - Ajoute: `likes_count` (compteur de likes)

- `2026_02_17_170544_create_actualite_likes_table.php`
  - Table: `actualite_likes` pour gérer les réactions individuelles
  - Champs: actualite_id, user_identifier, reaction_type (like, love, wow, sad, angry)
  - Index unique: (actualite_id, user_identifier) pour un seul like par utilisateur

### 2. Modèles

#### Actualite.php
- Mise à jour des `$fillable` pour inclure: `video`, `video_type`, `likes_count`
- Nouvelles méthodes:
  - `likes()` - Relation hasMany vers ActualiteLike
  - `likesByType($type)` - Compter likes par type de réaction
  - `hasLiked($userIdentifier)` - Vérifier si utilisateur a aimé
  - `getUserReaction($userIdentifier)` - Obtenir la réaction de l'utilisateur

#### ActualiteLike.php (Nouveau)
- Modèle pour gérer les réactions individuelles
- Relation belongsTo vers Actualite

### 3. API Endpoints

#### Routes API Créées:
```
POST   /api/actualites/{actualite}/like           - Ajouter/Retirer une réaction
GET    /api/actualites/{actualite}/like/stats     - Obtenir statistiques complètes
GET    /api/actualites/{actualite}/like/user-reaction  - Réaction de l'utilisateur
```

#### Contrôleur ActualiteLikeController
- `toggle()` - Ajouter/Retirer/Changer réaction
- `stats()` - Retourner statistiques par type
- `userReaction()` - Obtenir réaction utilisateur

### 4. Contrôleurs

#### Admin/ActualiteController.php
- `store()` - Mise à jour validation pour vidéos (50MB max)
- `update()` - Gestion vidéos avec suppression de l'ancienne
- `destroy()` - Suppression vidéos locales

#### Api/ActualiteController.php
- `index()` - Retourne données enrichies (video, likes_count, temps_lecture, etc.)
- `show()` - Retourne actualité complète + stats likes
- Transformation des données pour inclure attributs calculés

### 5. Routes Web

#### Actualités Publiques
- `/actualites` - Liste avec attributs enrichis
- `/actualites/{slug}` - Détail avec stats likes

### 6. Composants Vue

#### ActualiteCard.vue (Mis à jour)
- Support vidéo avec badge "Vidéo"
- Affichage likes dans le footer
- Gestion gracieuse des cas sans image/vidéo
- Design responsive amélioré

#### ActualiteDetail.vue (Nouveau)
- Composant complet pour afficher un article en détail
- Support vidéo (upload, YouTube, Vimeo)
- Système de réactions interactif
- Statistiques des réactions

### 7. Pages Inertia

#### Admin/Actualites/Create.vue
- Nouveau champ upload vidéo
- Validation affichée côté client

#### Admin/Actualites/Edit.vue
- Gestion remplacement vidéo
- Affichage vidéo actuellement associée
- Option suppression vidéo actuelle

#### Actualites/Show.vue (Page Publique)
- Affichage vidéos (upload, YouTube, Vimeo)
- Système de réactions avec picker emoji
- Statistiques de réactions détaillées
- Gracieuse gestion cas sans media
- Compteur de réactions dans les métadonnées

## Installation et Utilisation

### 1. Exécuter les Migrations
```bash
php artisan migrate
```

### 2. Créer Dossiers de Stockage
Les dossiers suivants seront créés automatiquement:
- `public/images/actualites/` - Images articles
- `public/images/actualites/content/` - Images contenu WYSIWYG
- `public/videos/actualites/` - Vidéos uploadées

### 3. Utilisation Admin

#### Créer/Modifier un Article:
1. Aller sur Admin → Actualités → Nouveau/Modifier
2. Remplir titre, extrait, contenu (comme avant)
3. **(Nouveau)** Uploader une image de couverture (optionnel)
4. **(Nouveau)** Uploader une vidéo OU entrer URL YouTube/Vimeo (optionnel)
5. Sélectionner catégorie, auteur, date publication
6. Publier ou enregistrer comme brouillon

#### Upload Vidéo:
- Formats acceptés: MP4, WebM, MOV, AVI, FLV
- Taille maximale: 50 MB
- Alternative: Fournir URL YouTube/Vimeo au lieu d'uploader

### 4. Client (Utilisateurs)

#### Consulter les Actualités:
1. Aller sur `/actualites`
2. Les articles avec vidéos affichent un badge "Vidéo" sur la miniature
3. Les compteurs de likes sont affichés

#### Liker un Article:
1. Ouvrir un article détail `/actualites/{slug}`
2. Cliquer sur le bouton cœur
3. Sélectionner un type de réaction (👍 like, ❤️ love, 😮 wow, 😢 sad, 😠 angry)
4. Les réactions sont sauvegardées localement (via localStorage)
5. Voir les statistiques par type de réaction

## Détails Techniques

### Gestion des Identifiants Utilisateurs
- Les utilisateurs anonymes sont identifiés par un UUID aléatoire généré et stocké en localStorage
- Chaque utilisateur (authentifié ou pas) peut avoir 1 réaction par article
- Changement de réaction remplace l'ancienne
- Même réaction = suppression du like

### Formats Vidéo Supportés

#### Upload Local:
- MP4, WebM, MOV, AVI, FLV
- Max 50 MB
- Stockage: `public/videos/actualites/`

#### YouTube:
- URL format: `https://www.youtube.com/watch?v=VIDEO_ID`
- Ou: `https://youtu.be/VIDEO_ID`
- Conversion automatique en embed

#### Vimeo:
- URL format: `https://vimeo.com/VIDEO_ID`
- Conversion automatique en embed

### Cas Limites Gérés

1. **Pas d'image ni vidéo**: Affiche gradient coloré avec icône placeholder
2. **Vidéo sans image**: Affiche vidéo en plein pour sur la page détail
3. **Plusieurs uploads**: Dernière vidéo remplace l'ancienne automatiquement
4. **Suppression article**: Vidéos locales supprimées du disque automatiquement

## API Exemples

### Ajouter une réaction
```javascript
POST /api/actualites/1/like
{
  "user_identifier": "user-123",
  "reaction_type": "love"
}

Response:
{
  "success": true,
  "liked": true,
  "reaction_type": "love",
  "likes_count": 5
}
```

### Obtenir les stats
```javascript
GET /api/actualites/1/like/stats

Response:
{
  "total": 5,
  "by_type": {
    "like": 2,
    "love": 2,
    "wow": 1,
    "sad": 0,
    "angry": 0
  }
}
```

### Vérifier réaction utilisateur
```javascript
GET /api/actualites/1/like/user-reaction?user_identifier=user-123

Response:
{
  "reaction_type": "love"
}
```

## Améliorations Futures Possibles

1. Authentifier l'API pour les utilisateurs enregistrés
2. Ajouter commentaires aux articles
3. Partage social intégré
4. Compression automatique vidéos
5. Streaming vidéo adaptatif (HLS/DASH)
6. Système de notifications pour nouvelles actualités
7. Recommandations basées sur les likes
8. Statistiques détaillées (admin)

## Support et Dépannage

### Erreurs d'Upload Vidéo
- Vérifier perms dossiers: `chmod 755 public/videos/actualites/`
- Vérifier taille max PHP (php.ini): `upload_max_filesize = 50M`
- Vérifier post_max_size: `post_max_size = 50M`

### Réactions Non Sauvegardées
- Vérifier localStorage enabled dans navigateur
- Vérifier requête POST va à `/api/actualites/{id}/like`
- Vérifier token CSRF si erreur 419

### Vidéos YouTube/Vimeo Non Affichées
- Vérifier format URL correct
- Vérifier vidéo public/accessible
- Vérifier pas de restrictions de pays
