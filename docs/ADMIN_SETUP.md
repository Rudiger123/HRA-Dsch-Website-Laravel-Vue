# 🧪 Guide de Test - Interface Admin HRA Dschang

## Étape 1 : Créer les utilisateurs de test

Un seeder a été créé pour générer les utilisateurs test. Exécutez :

```bash
# Générer les utilisateurs test
php artisan db:seed --class=AdminTestSeeder

# OU si tu veux réinitialiser la base de données entière
php artisan migrate:fresh --seed
```

## 📝 Utilisateurs de test créés

### 🔐 Super Admin
- **Email** : `admin@hradschang.cm`
- **Password** : `password123`
- **Rôle** : Super Administrateur
- **Permissions** : Accès complet à tout

### 👤 Réceptionniste
- **Email** : `accueil@hradschang.cm`
- **Password** : `password123`
- **Rôle** : Réceptionniste
- **Permissions** : Gestion des RDV et messages

### 🩺 Médecin
- **Email** : `medecin@hradschang.cm`
- **Password** : `password123`
- **Rôle** : Médecin
- **Permissions** : Voir ses informations et RDV

---

## Étape 2 : Compiler les assets

```bash
# Développement
npm run dev

# Production
npm run build
```

---

## Étape 3 : Tester l'interface

### 🌐 Page de connexion
```
URL: http://localhost:8000/admin/login
```

### ✅ Tests recommandés

#### 1. Connexion Super Admin
```
Email: admin@hradschang.cm
Password: password123
```

**Vérifier que vous voyez** :
- ✅ Dashboard avec toutes les statistiques
- ✅ Menu complet : Services, Médecins, Actualités, RDV, Messages, Tarifs, Horaires, Utilisateurs, Journal d'activité
- ✅ Avatar de l'utilisateur en haut à droite
- ✅ Sidebar responsive sur mobile

#### 2. Connexion Réceptionniste
```
Email: accueil@hradschang.cm
Password: password123
```

**Vérifier que vous voyez** :
- ✅ Dashboard avec statistiques RDV
- ✅ Menu limité : Services, Médecins, Actualités, RDV, Messages
- ✅ Pas de : Utilisateurs, Journal d'activité, Tarifs (selon permissions)

#### 3. Connexion Médecin
```
Email: medecin@hradschang.cm
Password: password123
```

**Vérifier que vous voyez** :
- ✅ Dashboard simple
- ✅ Menu limité : ses RDV uniquement
- ✅ Pas d'accès à la gestion

---

## 🧬 Architecture des Permissions

### Super Admin
```php
// Accès à TOUT
- view_services
- create_services
- update_services
- delete_services
- view_medecins
- view_actualites
- view_all_rdv
- view_contacts
- manage_tarifs
- manage_horaires
- view_users
- view_audit_log
```

### Réceptionniste
```php
- view_services
- view_medecins
- view_actualites
- view_all_rdv (tous les RDV)
- view_contacts
```

### Médecin
```php
- view_own_rdv (ses RDV seulement)
```

---

## 📊 Dashboard - Éléments affichés

Pour le **Super Admin**, le dashboard affiche :

1. **Statistiques générales**
   - Nombre de services actifs
   - Nombre de médecins actifs
   - Nombre d'articles publiés
   - Nombre de RDV en attente

2. **Statistiques RDV**
   - RDV confirmés
   - RDV annulés
   - Total RDV

3. **Sections conditionnelles**
   - Rendez-vous du jour (si permission `view_all_rdv`)
   - Messages récents (si permission `view_contacts`)
   - Services les plus demandés
   - Activité récente (si permission `view_audit_log`)

---

## 🐛 Dépannage

### Erreur : "Route not found"
```
Vérifiez que les routes admin existent dans routes/web.php
```

### Erreur : "Class not found"
```bash
composer dump-autoload
```

### Erreur : "Relation not found"
```bash
# Vérifiez que les migrations sont bien exécutées
php artisan migrate
```

### Erreur : "Permission denied"
```
Vérifiez que le fichier Database/Seeders/RolePermissionSeeder.php
crée bien les permissions requises
```

---

## 🎯 Checklist Finale

- [ ] Build sans erreurs : `npm run build`
- [ ] Page login accessible : http://localhost:8000/admin/login
- [ ] Connexion Super Admin fonctionne
- [ ] Dashboard apparaît après connexion
- [ ] Sidebar navigation fonctionne
- [ ] Responsive sur mobile
- [ ] Flash messages s'affichent correctement
- [ ] Déconnexion fonctionne
- [ ] Permissions restrictives fonctionnent (Réceptionniste, Médecin)

---

## 📝 Notes de développement

Los fichiers créés :
- `resources/js/Layouts/AdminLayout.vue` - Layout principal
- `resources/js/Pages/Admin/Dashboard.vue` - Dashboard
- `resources/js/Pages/Auth/Login.vue` - Page connexion
- `database/seeders/AdminTestSeeder.php` - Seeders des utilisateurs test
- `app/Http/Middleware/HandleInertiaRequests.php` - Middleware mis à jour

Prochaines étapes recommandées :
1. Créer les routes admin admin (`routes/web.php`)
2. Créer les contrôleurs admin (`app/Http/Controllers/Admin/`)
3. Implémenter les formulaires CRUD
4. Ajouter les validations
