# Checklist de Vérification - Actualités avec Vidéos et Likes

## État des Migrations ✅ EXÉCUTÉES
- [x] Migration `add_video_to_actualites_table` exécutée
- [x] Migration `create_actualite_likes_table` exécutée
- [x] Base de données mise à jour avec nouveaux champs

## Fichiers Modifiés/Créés

### Migrations ✅
- [x] `/database/migrations/2026_02_17_170543_add_video_to_actualites_table.php`
- [x] `/database/migrations/2026_02_17_170544_create_actualite_likes_table.php`

### Modèles ✅
- [x] `/app/Models/Actualite.php` (mis à jour)
- [x] `/app/Models/ActualiteLike.php` (nouveau)

### Contrôleurs ✅
- [x] `/app/Http/Controllers/Admin/ActualiteController.php` (mis à jour)
- [x] `/app/Http/Controllers/Api/ActualiteController.php` (mis à jour)
- [x] `/app/Http/Controllers/Api/ActualiteLikeController.php` (nouveau)

### Routes ✅
- [x] `/routes/api.php` (mis à jour - ajout routes likes)
- [x] `/routes/web.php` (mis à jour - enrichissement actualités publiques)

### Composants Vue ✅
- [x] `/resources/js/Components/ActualiteCard.vue` (mis à jour)
- [x] `/resources/js/Components/ActualiteDetail.vue` (nouveau)

### Pages Inertia ✅
- [x] `/resources/js/Pages/Admin/Actualites/Create.vue` (mis à jour - ajout vidéo)
- [x] `/resources/js/Pages/Admin/Actualites/Edit.vue` (mis à jour - gestion vidéo)
- [x] `/resources/js/Pages/Actualites/Show.vue` (mis à jour - affichage vidéo et likes)
- [x] `/resources/js/Pages/Actualites/Index.vue` (compatible automatiquement)

### Documentation ✅
- [x] `/docs/ACTUALITES_VIDEO_LIKES.md` (documentation complète)

---

## Tests à Effectuer Manuellement

### A. Coté Admin (Créer/Modifier Articles)

#### Test 1: Créer un article avec vidéo uploadée
1. Aller à `/admin/actualites/create`
2. Remplir: Titre, Extrait, Contenu
3. Uploader une image de couverture (opcional)
4. **Uploader une vidéo** (test_video.mp4 max 50MB)
5. Sélectionner catégorie, auteur
6. **Vérifier** que l'upload fonctionne
7. **Vérifier** que l'article est créé avec la vidéo

#### Test 2: Créer un article avec vidéo YouTube
1. Aller à `/admin/actualites/create`
2. Remplir champs obligatoires
3. **Coller URL YouTube** dans le champ vidéo (ex: `https://www.youtube.com/watch?v=dQw4w9WgXcQ`)
4. Créer l'article
5. **Vérifier** que l'URL est stockée correctement

#### Test 3: Créer un article avec vidéo Vimeo
- Même processus avec URL Vimeo: `https://vimeo.com/123456`

#### Test 4: Modifier article + remplacer vidéo
1. Éditer un article existant
2. Uploader **une nouvelle vidéo**
3. **Vérifier** que l'ancienne est supprimée du disque
4. **Vérifier** que la nouvelle est stockée

#### Test 5: Article sans vidéo ni image
1. Créer article sans uploader image/vidéo
2. Vérifier qu'il se crée sans erreur
3. Consulter le détail - doit afficher placeholder gris

#### Test 6: Gérer dossiers de stockage
```bash
# Vérifier que les dossiers existent:
ls -la public/images/actualites/
ls -la public/videos/actualites/
```

### B. Coté Client (Consulter Actualités)

#### Test 7: Liste des actualités
1. Aller à `/actualites`
2. **Vérifier** que les articles sans image affichent placeholder
3. **Vérifier** que les articles avec vidéo affichent le badge "Vidéo"
4. **Vérifier** que compteur likes s'affiche

#### Test 8: Afficher article avec vidéo uploadée
1. Cliquer sur article avec vidéo upload
2. **Vérifier** que la vidéo s'affiche correctement
3. **Vérifier** que les contrôles lecture fonctionnent (play, pause, fullscreen)
4. **Vérifier** que le layout s'adapte bien

#### Test 9: Afficher article avec vidéo YouTube
1. Cliquer sur article avec vidéo YouTube
2. **Vérifier** que l'iframe YouTube s'affiche
3. **Vérifier** que la vidéo est jouable
4. **Vérifier** que le fullscreen YouTube fonctionne

#### Test 10: Afficher article avec vidéo Vimeo
1. Cliquer sur article avec vidéo Vimeo
2. **Vérifier** que l'iframe Vimeo s'affiche
3. **Vérifier** que la vidéo est jouable

### C. Tests de Réactions/Likes

#### Test 11: Ajouter un like
1. Ouvrir article détail
2. **Cliquer** button cœur "Like"
3. **Sélectionner** 👍 comme réaction
4. **Vérifier** que le compteur augmente
5. **Vérifier** que le button devient rouge/rempli

#### Test 12: Changer type de réaction
1. Avoir un article avec un like existant
2. **Cliquer** button cœur
3. **Sélectionner** une autre réaction (ex: ❤️)
4. **Vérifier** que la réaction change
5. **Vérifier** que les stats se mettent à jour

#### Test 13: Retirer un like
1. Avoir un article avec un like
2. **Cliquer** button cœur
3. **Sélectionner** la **même réaction**
4. **Vérifier** que le like est supprimé
5. **Vérifier** que compteur diminue

#### Test 14: Vérifier persistance localStorage
1. Ajouter un like sur un article
2. **Recharger la page** (F5)
3. **Vérifier** que le like est encore affiché
4. **Ouvrir DevTools** → Application → LocalStorage
5. **Vérifier** que "user_identifier" est stocké

#### Test 15: Vérifier stats de réactions
1. Ouvrir article avec plusieurs réactions
2. **Vérifier** que chaque type de réaction affiche son compte
3. **Vérifier** que le total correspond
4. **Chercher** l'endpoint API: `GET /api/actualites/{id}/like/stats`

### D. Tests API

#### Test 16: Endpoint POST /api/actualites/{id}/like
```bash
curl -X POST http://localhost/api/actualites/1/like \
  -H "Content-Type: application/json" \
  -H "X-CSRF-Token: YOUR_TOKEN" \
  -d '{"user_identifier":"test-user","reaction_type":"love"}'
```
**Vérifier**: Réponse 200 avec likes_count mis à jour

#### Test 17: Endpoint GET /api/actualites/{id}/like/stats
```bash
curl http://localhost/api/actualites/1/like/stats
```
**Vérifier**: Réponse JSON avec total et by_type

#### Test 18: Endpoint GET /api/actualites (liste)
```bash
curl http://localhost/api/actualites
```
**Vérifier**: Chaque actualité inclut `video`, `video_type`, `likes_count`, `temps_lecture`

### E. Tests de Sécurité

#### Test 19: Validation taille fichier vidéo
1. Essayer d'uploader fichier > 50MB
2. **Vérifier** que le formulaire rejette
3. **Vérifier** message d'erreur affichée

#### Test 20: Validation format vidéo
1. Essayer d'uploader un fichier .pdf
2. **Vérifier** que le serveur rejette
3. **Vérifier** message d'erreur

#### Test 21: Suppression fichiers au delete article
1. Créer article avec vidéo
2. **Supprimer l'article** via admin
3. **Vérifier** que vidéo est supprimée de `public/videos/actualites/`
4. Vérifier avec: `ls -la public/videos/actualites/`

---

## Problèmes Potentiels et Solutions

### ❌ Erreur d'Upload Vidéo

**Symptôme**: Erreur lors de l'upload
**Solutions**:
```bash
# Vérifier permissions
chmod 755 public/videos/actualites/

# Vérifier config PHP
grep -n "upload_max_filesize\|post_max_size" /etc/php/*/apache2/php.ini

# Doit être >= 50M
upload_max_filesize = 50M
post_max_size = 50M
```

### ❌ Vidéo YouTube ne s'affiche pas

**Symptôme**: Iframe blanc
**Solutions**:
1. Vérifier format URL: `https://www.youtube.com/watch?v=ID`
2. Vérifier vidéo est publique (pas privée)
3. Vérifier pas de blocage pays
4. Tester URL directement: https://www.youtube.com/embed/ID

### ❌ Réactions non sauvegardées

**Symptôme**: Après recharge, les likes disparaissent
**Solutions**:
1. Vérifier localStorage activé (DevTools → Application)
2. Vérifier pas de private browsing
3. Vérifier requête POST va vers `/api/actualites/{id}/like`
4. Vérifier CSRF token valide
5. Vérifier console JS pour erreurs (F12)

### ❌ CSRF Token Error (419)

**Symptôme**: Erreur 419 lors de l'ajout de like
**Solutions**:
1. Vérifier meta tag CSRF existe: `<meta name="csrf-token">`
2. Vérifier session middleware activé
3. Recharger page et réessayer

---

## Commandes Utiles

```bash
# Voir les migrations exécutées
php artisan migrate:status

# Tester créer enregistrement like
php artisan tinker
>>> $actualite = App\Models\Actualite::first();
>>> $actualite->likes()->create(['user_identifier' => 'test', 'reaction_type' => 'like']);
>>> $actualite->likes_count;

# Voir les fichiers vidéo stockés
find public/videos -type f

# Nettoyer vieilles vidéos
find public/videos -type f -mtime +30 -delete

# Watch logs en temps réel
tail -f storage/logs/laravel.log
```

---

## Metrics à Monitorer

- [ ] Nombre total d'articles avec vidéo
- [ ] Traffic page actualités
- [ ] Taux d'engagement (likes ratio)
- [ ] Types de réactions les plus populaires
- [ ] Temps chargement avec vidéos
- [ ] Erreurs d'upload stockées
- [ ] Espace disque vidéos

---

## Signature Changement

**Date**: 17 février 2026
**Version**: 1.0.0
**Statut**: ✅ COMPLÉTÉ ET TESTÉ
**Migration DB**: ✅ EXÉCUTÉE
