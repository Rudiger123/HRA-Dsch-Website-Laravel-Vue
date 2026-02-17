# 📚 Documentation Complète - HRA Dschang Website v1.0

**Date de création:** 17 février 2026  
**Version de l'application:** 1.0.0  
**État:** Prêt pour production  
**Auteur:** Équipe HRA Dschang

---

## 📑 Table des matières

1. [Introduction et Vue d'ensemble](#introduction-et-vue-densemble)
2. [Architecture Technique](#architecture-technique)
3. [Guide d'Installation](#guide-dinstallation)
4. [Structure de la Base de Données](#structure-de-la-base-de-données)
5. [Modèles et Relations](#modèles-et-relations)
6. [Routes API](#routes-api)
7. [Routes Admin](#routes-admin)
8. [Contrôleurs](#contrôleurs)
9. [Système d'Authentification](#système-dauthentification)
10. [Système de Permissions](#système-de-permissions)
11. [Fonctionnalités](#fonctionnalités)
12. [Emails](#emails)
13. [Guide d'Utilisation Admin](#guide-dutilisation-admin)
14. [API Reference](#api-reference)
15. [Dépannage](#dépannage)

---

## Introduction et Vue d'ensemble

### À propos du projet

**HRA Dschang Website** est une plateforme web moderne et professionnelle construite pour l'Hôpital HRA Dschang au Cameroun. Cette application permet aux patients et au public d'accéder aux informations médicales, de prendre rendez-vous, de consulter les tarifs et de contacter l'établissement.

### Objectifs principaux

- 🏥 **Présentation de l'établissement:** Afficher les services médicaux avec descriptions complètes
- 👨‍⚕️ **Gestion du personnel:** Présenter les médecins, spécialités et services
- 📅 **Système de rendez-vous:** Permettre aux patients de demander des rendez-vous en ligne
- 💰 **Tarification:** Afficher les tarifs des services par patient
- ⏰ **Horaires:** Gérer et afficher les horaires d'ouverture par service
- 📰 **Actualités:** Blog avec vidéos, likes et réactions
- 💬 **Contact:** Formulaire de contact avec notifications administrateur
- 🔐 **Administration sécurisée:** Interface admin protégée avec permissions rôles

### Caractéristiques clés

✅ Interface responsive (mobile-first)  
✅ SEO optimisé avec metabalisations  
✅ Vue 3 avec Inertia.js (SSR)  
✅ Tailwind CSS 4 pour styling moderne  
✅ API RESTful complète  
✅ Authentification Laravel Sanctum  
✅ Système de rôles et permissions (Spatie)  
✅ Activity Logging (audit trail)  
✅ Emails personnalisés  
✅ Database sqlite avec relations optimisées  

---

## Architecture Technique

### Stack technologique

```
┌─────────────────────────────────────────────────────────┐
│                    Frontend (Vue 3)                      │
│  ├─ Inertia.js v2 (SSR)                                 │
│  ├─ Tailwind CSS 4.0                                    │
│  ├─ Lucide Vue Icons                                    │
│  └─ TipTap Rich Editor                                  │
├─────────────────────────────────────────────────────────┤
│                    Backend (Laravel 12)                  │
│  ├─ Eloquent ORM                                        │
│  ├─ Authentication (Sanctum)                            │
│  ├─ Permissions (Spatie)                                │
│  ├─ Activity Logging (Spatie)                           │
│  └─ SEO Tools (Artesaos)                                │
├─────────────────────────────────────────────────────────┤
│                 Build Tool & DevOps                      │
│  ├─ Vite 7.0                                            │
│  ├─ Laravel Sail (Docker)                               │
│  ├─ SQLite (dev)                                        │
│  └─ Concurrently (dev server)                           │
└─────────────────────────────────────────────────────────┘
```

### Dépendances principales

**Backend:**
- `laravel/framework` v12.0 - Framework PHP
- `inertiajs/inertia-laravel` v2.0 - Rendu côté serveur
- `spatie/laravel-permission` v7.1 - Rôles et permissions
- `spatie/laravel-activitylog` v4.11 - Audit trail
- `artesaos/seotools` v1.3 - Métadonnées SEO
- `tightenco/ziggy` v2.6 - Routes front accessible
- `spatie/laravel-sitemap` v7.3 - Sitemap automatique

**Frontend:**
- `vue` v3.5.28 - Framework JavaScript
- `@inertiajs/vue3` v2.3.14 - Intégration Inertia
- `tailwindcss` v4.0.0 - Utilitaires CSS
- `@tiptap/vue-3` v3.19.0 - Éditeur riche
- `lucide-vue-next` v0.564.0 - Iconothèque

**Dev:**
- `phpunit/phpunit` v11.5.3 - Tests
- `vite` v7.0.7 - Build tool
- `laravel-vite-plugin` v2.0.0 - Plugin Laravel/Vite

### Environnement d'exécution

```
Node.js:  v18+
PHP:      v8.2+
Database: SQLite (dev) / MySQL (prod)
Port:     8000 (Laravel Artisan)
Port:     5173 (Vite Dev Server)
```

---

## Guide d'Installation

### Prérequis

```bash
# Vérifier Node.js
node --version  # v18.x minimum

# Vérifier PHP
php --version   # v8.2 minimum

# Vérifier Composer
composer --version
```

### Installation développement

```bash
# 1. Cloner le projet
git clone <repository-url>
cd hrad-site

# 2. Installation automatique
composer run-script setup

# 3. Générateur de clé d'application
php artisan key:generate

# 4. Migrations de base
php artisan migrate

# 5. Seeders (données test)
php artisan db:seed

# 6. Installation des dépendances Node
npm install

# 7. Démarrer le serveur de développement
composer run dev
```

### Installation production

```bash
# 1. Préparation du .env
cp .env.example .env
nano .env  # Configurer les variables

# 2. Installation des dépendances
composer install --no-dev
npm install --production

# 3. Build frontend
npm run build

# 4. Optimisation Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Migrations
php artisan migrate --force

# 6. Permissions fichiers
chmod -R 755 storage bootstrap/cache

# 7. Démarrage serveur
php artisan serve --host=0.0.0.0 --port=80
```

### Variables d'environnement (.env)

```env
APP_NAME=HRA-Dschang
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hra_dschang
DB_USERNAME=root
DB_PASSWORD=secure_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=admin@hra-dschang.cm
MAIL_PASSWORD=app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=admin@hra-dschang.cm
MAIL_FROM_NAME="HRA Dschang"
```

---

## Structure de la Base de Données

### Diagramme des relations

```
users (Administrateurs)
    ├─ roles (N:M via model_has_roles)
    └─ permissions (N:M via model_has_permissions)

services (Services médicaux)
    ├─ horaires (1:N)
    ├─ tarifs (1:N)
    ├─ rdv_requests (1:N)
    └─ medecins (N:M via medecin_service)

medecins (Équipe médicale)
    └─ services (N:M via medecin_service)

rdv_requests (Demandes de rendez-vous)
    └─ services (N:1)

actualites (Blog/Actualités)
    └─ actualite_likes (1:N)

contacts (Messages formulaire)
```

### Description des tables

#### 1. **Users - Administrateurs**

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint(PK) | Identifiant unique |
| name | string(191) | Nom complet |
| email | string(191, unique) | Email professionnel |
| email_verified_at | timestamp | Date vérification email |
| password | string(191) | Mot de passe hashé |
| phone | string(191) | Téléphone professionnel |
| photo | string(191) | Chemin photo profil |
| is_active | boolean | Compte actif/inactif |
| remember_token | string(100) | Token "Se souvenir de moi" |
| deleted_at | timestamp | Soft delete |
| created_at | timestamp | Date création |
| updated_at | timestamp | Date modification |

**Spécifications:**
- Authentification par email/mot de passe
- Soft deletes pour conservation historique
- Roles assignables (Super Admin, Admin, User)
- Photo de profil optionnelle

#### 2. **Services - Services médicaux**

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint(PK) | Identifiant unique |
| nom | string(100) | Nom service (ex: "Pédiatrie") |
| slug | string(100, unique) | URL-friendly slug |
| description | text | Description complète |
| icon | string(50) | Nom icône Lucide |
| tarif_consultation | integer | Tarif consultation (FCFA) |
| actif | boolean | Service visible/caché |
| ordre | integer | Position affichage |
| created_at | timestamp | Date création |
| updated_at | timestamp | Date modification |

**Spécifications:**
- Tarif consultation par défaut
- Icônes Lucide pour représentation visuelle
- Tri par champ `ordre`
- Services inactifs masqués sur le site public

#### 3. **Medecins - Équipe médicale**

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint(PK) | Identifiant unique |
| nom | string(150) | Nom complet médecin |
| slug | string(150, unique) | URL-friendly slug |
| specialite | string(150) | Spécialité (ex: "Pédiatre") |
| diplomes | text | Diplômes et certifications |
| photo | string(191) | Chemin photo passport |
| bio | text | Biographie complète |
| langues | text | Langues parlées (JSON) |
| actif | boolean | Médecin actif |
| created_at | timestamp | Date création |
| updated_at | timestamp | Date modification |

**Spécifications:**
- N:M relationship avec services
- Photo stockée dans `storage/app/public/medecins/`
- Langues en JSON array
- Plusieurs spécialités possibles

#### 4. **Medecin_Service - Pivot table (N:M)**

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint(PK) | Identifiant unique |
| medecin_id | bigint(FK) | Référence médecin |
| service_id | bigint(FK) | Référence service |
| timestamps | - | Audit trail |

#### 5. **Horaires - Horaires d'ouverture**

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint(PK) | Identifiant unique |
| service_id | bigint(FK) | Référence service |
| jour_semaine | enum | Lun-Dim |
| ouverture | time | Ex: 08:00:00 |
| fermeture | time | Ex: 17:00:00 |
| note | string(200) | Ex: "Urgences: 24/24" |
| created_at | timestamp | Date création |
| updated_at | timestamp | Date modification |

**Spécifications:**
- Un horaire par jour par service
- Note optionnelle pour exceptions
- Suppression en cascade si service supprimé

#### 6. **Tarifs - Tarification**

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint(PK) | Identifiant unique |
| service_id | bigint(FK) | Référence service |
| designation | string(150) | Ex: "Accouchement normal" |
| montant | integer | Prix (FCFA) |
| type_patient | enum | normal/etudiant/urgence |
| details | text | Inclusions/exclusions |
| created_at | timestamp | Date création |
| updated_at | timestamp | Date modification |

**Spécifications:**
- Tarifs différenciés par type patient
- Montant en FCFA (devise camerounaise)
- Détails négociables selon cas

#### 7. **RDV Requests - Demandes de rendez-vous**

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint(PK) | Identifiant unique |
| nom_patient | string(150) | Nom complet patient |
| age | integer | Âge patient |
| telephone | string(20) | Format +237XXXXXXXXX |
| email | string(191) | Email patient |
| service_id | bigint(FK) | Service demandé |
| motif | text | Raison consultation |
| statut | enum | en_attente/confirme/annule |
| confirmation_whatsapp | boolean | Confirmé via WhatsApp |
| date_souhaitee | timestamp | Date demandée |
| created_at | timestamp | Date création |
| updated_at | timestamp | Date modification |

**Statuts:**
- `en_attente` - Nouvelle demande (défaut)
- `confirme` - Approuvée administrateur
- `annule` - Refusée ou annulée

#### 8. **Contacts - Messages formulaire**

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint(PK) | Identifiant unique |
| nom | string(150) | Nom expéditeur |
| email | string(150) | Email expéditeur |
| telephone | string(20) | Téléphone optionnel |
| message | text | Corps du message |
| lu | boolean | Message lu par admin |
| created_at | timestamp | Date création |
| updated_at | timestamp | Date modification |

#### 9. **Actualites - Articles/Blog**

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint(PK) | Identifiant unique |
| titre | string(191) | Titre article |
| slug | string(191, unique) | URL slug (auto-généré) |
| extrait | text | Résumé court (200 car) |
| contenu | longtext | Contenu riche HTML |
| image | string(191) | Chemin image couverture |
| video | string(191) | URL vidéo YouTube |
| video_type | enum | youtube/local |
| categorie | string(50) | nutrition/prévention/événements |
| auteur | string(100) | Nom auteur |
| publie | boolean | Article publié |
| date_publication | timestamp | Date publication |
| vues | integer | Compteur vues |
| likes_count | integer | Cache compteur likes |
| created_at | timestamp | Date création |
| updated_at | timestamp | Date modification |

#### 10. **Actualite Likes - Reactions**

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint(PK) | Identifiant unique |
| actualite_id | bigint(FK) | Référence article |
| user_identifier | string(191) | IP ou user_id |
| reaction_type | enum | like/love/wow/sad/angry |
| created_at | timestamp | Date création |

#### 11. **Permission tables (Spatie)**

Gestion des rôles et permissions:
- `roles` - Définition des rôles
- `permissions` - Définition des permissions
- `model_has_roles` - Rôles assignés aux users
- `model_has_permissions` - Permissions directes aux users
- `role_has_permissions` - Permissions des rôles

#### 12. **Activity Log**

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint(PK) | Identifiant unique |
| log_name | string | Type d'action |
| description | text | Description action |
| subject_type | string | Type modèle modifié |
| subject_id | bigint | ID modèle modifié |
| causer_type | string | Type utilisateur |
| causer_id | bigint | ID utilisateur |
| properties | json | Données JSON |
| created_at | timestamp | Date action |

---

## Modèles et Relations

### Vue d'ensemble des modèles

```
app/Models/
├── User.php              (Administrateur)
├── Service.php           (Service médical)
├── Medecin.php          (Médecin/docteur)
├── Horaire.php          (Horaires ouverture)
├── Tarif.php            (Tarification)
├── RdvRequest.php       (Demande rendez-vous)
├── Contact.php          (Message contact)
├── Actualite.php        (Article/Blog)
└── ActualiteLike.php    (Réaction article)
```

### Classe User

**Fichier:** `app/Models/User.php`

```php
class User extends Authenticatable {
    use HasFactory, Notifiable, HasRoles, LogsActivity, SoftDeletes;
    
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'photo', 'is_active'
    ];
    
    // Relations
    public function roles()           // Spatie HasRoles
    public function permissions()     // Spatie HasRoles
    
    // Activity Log Configuration
    public function getActivitylogOptions(): LogOptions
}
```

**Traits:**
- `HasFactory` - Factories pour tests
- `Notifiable` - Notifications email
- `HasRoles` - Gestion rôles/permissions (Spatie)
- `LogsActivity` - Audit trail automatique
- `SoftDeletes` - Suppressions réversibles

**Fillable:**
- name, email, password (hashé automatiquement)
- phone, photo, is_active

**Casts:**
- email_verified_at → datetime
- password → hashed
- is_active → boolean

### Classe Service

**Fichier:** `app/Models/Service.php`

```php
class Service extends Model {
    protected $fillable = [
        'nom', 'slug', 'description', 'icon',
        'tarif_consultation', 'actif', 'ordre'
    ];
    
    // Relations
    public function horaires(): HasMany
    public function tarifs(): HasMany
    public function rdvRequests(): HasMany
    public function medecins(): BelongsToMany
    
    // Scopes
    public function scopeActif($query)
    public function scopeOrdonne($query)
}
```

**Relations:**
- 1:N avec Horaires
- 1:N avec Tarifs
- 1:N avec RdvRequests
- N:M avec Medecins (via `medecin_service`)

**Scopes:**
- `actif()` - Retourne services actifs
- `ordonne()` - Tri par champ `ordre`

### Classe Medecin

**Fichier:** `app/Models/Medecin.php`

```php
class Medecin extends Model {
    protected $table = 'medecins';
    
    protected $fillable = [
        'nom', 'slug', 'specialite', 'diplomes',
        'photo', 'bio', 'langues', 'actif'
    ];
    
    // Relations
    public function services(): BelongsToMany
    
    // Scopes
    public function scopeActif($query)
    public function scopeParSpecialite($query, $specialite)
}
```

**Relations:**
- N:M avec Services (via `medecin_service`)

**Scopes:**
- `actif()` - Médecins actifs
- `parSpecialite($spec)` - Filtrer par spécialité

### Classe RdvRequest

**Fichier:** `app/Models/RdvRequest.php`

```php
class RdvRequest extends Model {
    protected $fillable = [
        'nom_patient', 'age', 'telephone', 'email',
        'service_id', 'motif', 'confirmation_whatsapp',
        'date_souhaitee'
    ];
    
    protected $casts = [
        'confirmation_whatsapp' => 'boolean',
        'date_souhaitee' => 'datetime'
    ];
    
    // Relations
    public function service(): BelongsTo
}
```

**Statuts disponibles:**
- `en_attente` - Non traitée
- `confirme` - Approuvée
- `annule` - Refusée

### Classe Actualite

**Fichier:** `app/Models/Actualite.php`

```php
class Actualite extends Model {
    protected $fillable = [
        'titre', 'slug', 'extrait', 'contenu', 'image',
        'video', 'video_type', 'categorie', 'auteur',
        'publie', 'date_publication', 'vues', 'likes_count'
    ];
    
    protected $casts = [
        'date_publication' => 'datetime',
        'publie' => 'boolean',
        'vues' => 'integer',
        'likes_count' => 'integer'
    ];
    
    // Slug auto-généré depuis titre
    protected static function boot()
    
    // Relations
    public function likes(): HasMany
    
    // Accesseurs
    public function getDateFormatteeAttribute()
    public function getTempsLectureAttribute()
}
```

**Catégories:**
- nutrition
- prévention
- événements
- autres

**Fonctionnalités:**
- Auto-génération du slug
- Comptage vues
- Réactions (likes)
- Temps de lecture estimé
- Formatage date en français

### Classe ActualiteLike

**Fichier:** `app/Models/ActualiteLike.php`

```php
class ActualiteLike extends Model {
    protected $fillable = [
        'actualite_id', 'user_identifier', 'reaction_type'
    ];
    
    // Relations
    public function actualite(): BelongsTo
}
```

**Reaction types:**
- like
- love
- wow
- sad
- angry

### Classe Tarif

**Fichier:** `app/Models/Tarif.php`

```php
class Tarif extends Model {
    protected $fillable = [
        'service_id', 'designation', 'montant',
        'type_patient', 'details'
    ];
    
    protected $casts = [
        'montant' => 'integer'
    ];
    
    // Relations
    public function service(): BelongsTo
}
```

**Types patients:**
- normal
- etudiant
- urgence

### Classe Horaire

**Fichier:** `app/Models/Horaire.php`

```php
class Horaire extends Model {
    protected $fillable = [
        'service_id', 'jour_semaine', 'ouverture',
        'fermeture', 'note'
    ];
    
    protected $casts = [
        'ouverture' => 'datetime:H:i',
        'fermeture' => 'datetime:H:i'
    ];
    
    // Relations
    public function service(): BelongsTo
}
```

**Jours de semaine:**
- Lundi, Mardi, Mercredi, Jeudi
- Vendredi, Samedi, Dimanche

### Classe Contact

**Fichier:** `app/Models/Contact.php`

```php
class Contact extends Model {
    protected $fillable = [
        'nom', 'email', 'telephone', 'message'
    ];
}
```

---

## Routes API

### Endpoints publics (pas d'authentification)

#### Services
```
GET     /api/services              Lister tous les services actifs
GET     /api/services/{slug}       Détails d'un service
```

#### Actualités
```
GET     /api/actualites/categories Lister toutes les catégories
GET     /api/actualites            Lister articles publiés (paginated)
GET     /api/actualites/{slug}     Détails article + incrémenter vues
```

#### Likes/Réactions
```
POST    /api/actualites/{id}/like                  Toggle like (create/delete)
GET     /api/actualites/{id}/like/stats            Stats likes par type
GET     /api/actualites/{id}/like/user-reaction    Réaction utilisateur
```

#### Demandes RDV
```
POST    /api/rdv-requests          Créer demande rendez-vous
  Body: {
    nom_patient: string (150)
    age: int
    telephone: string (20)
    email: string (191)
    service_id: bigint
    motif: text (optionnel)
    date_souhaitee: datetime (optionnel)
  }
```

#### Contact
```
POST    /api/contacts              Envoyer message contact
  Body: {
    nom: string (150)
    email: string (150)
    telephone: string (20, optionnel)
    message: text
  }
```

### Endpoints authentifiés

#### Recherche globale
```
POST    /api/search/global         Recherche multi-modèles
  Headers: Authorization: Bearer {token}
  Body: {
    query: string
  }
```

---

## Routes Admin

Préfixe: `/admin/` | Middleware: `auth`, `active`

### Authentification

```
GET     /admin/login               Formulaire connexion
POST    /admin/login               Traiter connexion
POST    /admin/logout              Déconnexion
GET     /admin/forgot-password     Formulaire mot de passe oublié
POST    /admin/forgot-password     Envoyer lien reset
GET     /admin/reset-password/{token}  Formulaire reset
POST    /admin/reset-password      Traiter reset mot de passe
```

### Dashboard

```
GET     /admin/dashboard           Vue d'ensemble stats
```

### Gestion Services

```
GET     /admin/services            Lister services
GET     /admin/services/create     Formulaire création
POST    /admin/services            Stocker nouveau service
GET     /admin/services/{id}/edit  Formulaire modification
PUT     /admin/services/{id}       Mettre à jour service
DELETE  /admin/services/{id}       Supprimer service
POST    /admin/services/{id}/toggle-active  Activer/désactiver
```

### Gestion Médecins

```
GET     /admin/medecins            Lister médecins
GET     /admin/medecins/create     Formulaire création
POST    /admin/medecins            Stocker nouveau médecin
GET     /admin/medecins/{id}/edit  Formulaire modification
PUT     /admin/medecins/{id}       Mettre à jour médecin
DELETE  /admin/medecins/{id}       Supprimer médecin
DELETE  /admin/medecins/{id}/delete-photo  Supprimer photo
```

### Gestion Tarifs

```
GET     /admin/tarifs              Lister tarifs
POST    /admin/tarifs              Créer tarif
PATCH   /admin/tarifs/{id}         Mettre à jour tarif
DELETE  /admin/tarifs/{id}         Supprimer tarif
```

### Gestion Horaires

```
GET     /admin/horaires            Lister horaires
POST    /admin/horaires            Créer horaire
PATCH   /admin/horaires/{id}       Mettre à jour horaire
DELETE  /admin/horaires/{id}       Supprimer horaire
```

### Gestion Actualités

```
GET     /admin/actualites          Lister articles
GET     /admin/actualites/create   Formulaire création
POST    /admin/actualites          Stocker article
GET     /admin/actualites/{id}/edit  Formulaire modification
PUT     /admin/actualites/{id}     Mettre à jour article
DELETE  /admin/actualites/{id}     Supprimer article
POST    /admin/actualites/{id}/toggle-publish  Publier/dépublier
POST    /admin/actualites/upload-image  Upload image article
```

### Gestion Rendez-vous

```
GET     /admin/rdv-requests        Lister demandes RDV
GET     /admin/rdv-requests/{id}   Détails demande
PATCH   /admin/rdv-requests/{id}/status  Changer statut
GET     /admin/rdv-requests-statistics   Stats RDV
GET     /admin/rdv-requests-export       Export CSV
```

### Gestion Messages Contact

```
GET     /admin/contacts            Lister messages
GET     /admin/contacts/{id}       Lire message
POST    /admin/contacts/{id}/toggle-lu    Marquer lu/non-lu
POST    /admin/contacts/{id}/reply       Répondre par email
DELETE  /admin/contacts/{id}       Supprimer message
```

### Gestion Utilisateurs (Super Admin)

Middleware additionnel: `permission:view_users`

```
GET     /admin/users               Lister utilisateurs
GET     /admin/users/create        Formulaire création
POST    /admin/users               Créer utilisateur
GET     /admin/users/{id}/edit     Formulaire modification
PUT     /admin/users/{id}          Mettre à jour
DELETE  /admin/users/{id}          Supprimer utilisateur
POST    /admin/users/{id}/toggle-active  Activer/désactiver
POST    /admin/users/{id}/reset-password  Réinitialiser mot de passe
```

### Mon Profil

```
GET     /admin/profile             Éditer profil
PATCH   /admin/profile             Mettre à jour profil
POST    /admin/profile/photo       Télécharger photo
DELETE  /admin/profile/photo       Supprimer photo
PATCH   /admin/profile/password    Changer mot de passe
```

---

## Contrôleurs

### Architecture des contrôleurs

```
app/Http/Controllers/
├── Controller.php
├── Admin/
│   ├── DashboardController.php
│   ├── ServiceController.php
│   ├── MedecinController.php
│   ├── HoraireController.php
│   ├── TarifController.php
│   ├── RdvRequestController.php
│   ├── ContactController.php
│   ├── ActualiteController.php
│   ├── ProfileController.php
│   ├── UserController.php
│   └── ActivityLogController.php
├── Api/
│   ├── ServiceController.php
│   ├── ActualiteController.php
│   ├── ActualiteLikeController.php
│   ├── RdvRequestController.php
│   ├── ContactController.php
│   └── SearchController.php
└── Auth/
    ├── LoginController.php
    ├── ForgotPasswordController.php
    └── ResetPasswordController.php
```

### ServiceController (Admin)

**Location:** `app/Http/Controllers/Admin/ServiceController.php`

Gère le CRUD complet des services:
- `index()` - Afficher tous les services avec pagination
- `create()` - Formulaire création
- `store()` - Valider et stocker service
- `edit($id)` - Formulaire modification
- `update()` - Mettre à jour service
- `destroy()` - Supprimer service
- `toggleActive()` - Activer/désactiver

### MedecinController (Admin)

**Location:** `app/Http/Controllers/Admin/MedecinController.php`

Gère les médecins avec photos:
- `index()` - Lister médecins
- `create()` - Formulaire création
- `store()` - Créer médecin
- `edit()` - Éditer médecin
- `update()` - Mettre à jour avec upload photo
- `destroy()` - Supprimer médecin
- `deletePhoto()` - Supprimer photo uniquement

### ActualiteController (Admin)

**Location:** `app/Http/Controllers/Admin/ActualiteController.php`

Gestion complète des articles:
- `index()` - Lister articles
- `create()` - Formulaire creation
- `store()` - Créer article
- `edit()` - Éditer article
- `update()` - Mettre à jour
- `destroy()` - Supprimer article
- `togglePublish()` - Publier/dépublier
- `uploadImage()` - Upload image couverture AJAX

### RdvRequestController (Admin)

**Location:** `app/Http/Controllers/Admin/RdvRequestController.php`

Gestion des demandes de rendez-vous:
- `index()` - Lister demandes avec filtres
- `show()` - Détails demande
- `updateStatus()` - Changer statut (en_attente/confirme/annule)
- `statistics()` - Tableau de bord stats
- `export()` - Export CSV pour Excel

**Envoi emails automatiques:**
- Au client: Confirmation demande
- À l'admin: Nouvelle demande

### ContactController (Admin)

**Location:** `app/Http/Controllers/Admin/ContactController.php`

Gestion des messages de contact:
- `index()` - Lister messages
- `show()` - Lire dernier message
- `toggleLu()` - Marquer lu/non-lu
- `reply()` - Répondre par email
- `destroy()` - Supprimer message

### DashboardController (Admin)

**Location:** `app/Http/Controllers/Admin/DashboardController.php`

Tableau de bord admin:
- `index()` - Stats et KPIs
  - Total services/médecins
  - Rendez-vous par période
  - Messages non lus
  - Articles récents

### ProfileController (Admin)

**Location:** `app/Http/Controllers/Admin/ProfileController.php`

Profil utilisateur admin:
- `edit()` - Formulaire édition profil
- `update()` - Mettre à jour infos
- `updatePhoto()` - Télécharger photo
- `deletePhoto()` - Supprimer photo
- `updatePassword()` - Changer mot de passe

### UserController (Admin)

**Location:** `app/Http/Controllers/Admin/UserController.php`

Gestion utilisateurs (Super Admin only):
- `index()` - Lister utilisateurs
- `create()` - Créer utilisateur
- `store()` - Stocker
- `edit()` - Éditer
- `update()` - Mettre à jour
- `destroy()` - Supprimer
- `toggleActive()` - Activer/désactiver
- `resetPassword()` - Réinit mot de passe → email

### API Controllers

#### ServiceController (Api)

`app/Http/Controllers/Api/ServiceController.php`

- `index()` - Retourner services actifs (JSON)
- `show($slug)` - Retourner 1 service

#### ActualiteController (Api)

`app/Http/Controllers/Api/ActualiteController.php`

- `index()` - Articles publiés (paginated)
- `show($slug)` - Détails article + incr. vues
- `categories()` - Lister catégories

#### ActualiteLikeController (Api)

`app/Http/Controllers/Api/ActualiteLikeController.php`

- `toggle()` - Ajouter/retirer like
- `stats()` - Retourner stats likes par type
- `userReaction()` - Réaction utilisateur

#### RdvRequestController (Api)

`app/Http/Controllers/Api/RdvRequestController.php`

- `store()` - Créer demande RDV + emails

#### ContactController (Api)

`app/Http/Controllers/Api/ContactController.php`

- `store()` - Créer message + emails

#### SearchController (Api)

`app/Http/Controllers/Api/SearchController.php`

- `global()` - Recherche services, médecins, actualités

---

## Système d'Authentification

### Authentification Admin (Laravel Built-in)

**Fichier de configuration:** `config/auth.php`

```php
// Utilise le guard 'web' par défaut
'web' => [
    'driver' => 'session',
    'provider' => 'users',
]
```

### Processus d'authentification

#### 1. Connexion (`LoginController`)

```
GET /admin/login
  ↓
POST /admin/login (email, password)
  ↓
Validation + Authentification
  ↓
Redirection /admin/dashboard
  ↓
Session créée + Cookie XSRF
```

### 2. Vérification middleware

Middleware: `auth` - Redirige vers login si non authentifié
Middleware: `active` - Vérifie `is_active == true`

### 3. Déconnexion

```
POST /admin/logout
  ↓
Session détruite
  ↓
Redirection login
```

### Hachage des mots de passe

Tous les mots de passe sont hachés avec **Argon2** (plus sûr que bcrypt):

```php
'password' => 'hashed',  // Autocast au modèle User
Hash::make($password)     // Haché automatiquement
Hash::check($input, $hash) // Vérification
```

### Récupération de mot de passe

**Processus complet:**

1. User clique "Mot de passe oublié"
2. Saisit email
3. Système génère token unique + 60 min expiration
4. Email envoyé avec lien: `/admin/reset-password/{token}?email=...`
5. User clique lien
6. Formulaire reset mot de passe
7. Validation token + saisie nouveau mot de passe
8. Mise à jour dans BD + token supprimé

**Mail:** `PasswordResetMail.php`

### API Authentication (Sanctum)

Configuration: `config/sanctum.php`

```php
'tokens' => [
    'abilities' => ['*'],
    'expiration' => null,  // Pas d'expiration
]
```

Note: Actuellement pas utilisée pour l'API publique

---

## Système de Permissions

### Framework: Spatie Laravel Permission

**Package:** `spatie/laravel-permission` v7.1

### Configuration

Fichier: `config/permission.php`

```php
'roles_table' => 'roles',
'permissions_table' => 'permissions',
'model_has_roles' => 'model_has_roles',
'model_has_permissions' => 'model_has_permissions',
'role_has_permissions' => 'role_has_permissions',
```

### Rôles définis

#### 1. Super Admin
- Toutes permissions
- Gestion utilisateurs
- Accès complet système

#### 2. Admin
- Gestion services, médecins, tarifs
- Gestion actualités
- Gestion RDV et messages
- Pas accès gestion utilisateurs

#### 3. User (Optional)
- Lectures seules
- Peut être utilisé pour staff

### Permissions disponibles

```
view_users
create_users
edit_users
delete_users
view_audit_logs
manage_roles
```

### Utilisation dans les contrôleurs

```php
// Vérification dans les routes
Route::middleware('permission:view_users')->group(function () {
    Route::resource('users', UserController::class);
});

// Vérification dans le contrôleur
abort_if(!auth()->user()->can('edit_users'), 403);

// Dans les vues Inertia
can('delete_users')  // Accessible depuis le frontend
```

### Assigner rôles/permissions

```php
// Assigner rôle
$user->assignRole('admin');

// Retirer rôle
$user->removeRole('admin');

// Donner permission directe
$user->givePermissionTo('edit_users');

// Vérifier permission
$user->hasPermissionTo('delete_users');
```

---

## Fonctionnalités

### 1. Gestion des Services médicaux

**Vue client:**
- Affichage tous services avec description
- Tarif consultation par défaut
- Icône représentative

**Part admin:**
- CRUD complet services
- Activation/désactivation
- Tri par ordre
- Liée aux médecins, horaires, tarifs

**API:**
```
GET /api/services
GET /api/services/{slug}
```

### 2. Équipe médicale

**Vue client:**
- Fiche médecin avec photo
- Spécialité et bio
- Langues parlées
- Services associés

**Part admin:**
- Gestion profils médecins
- Upload photo passport
- Diplômes et certifications
- Affiliation services (N:M)

**Stockage photo:**
- `storage/app/public/medecins/`
- Redimensionnement auto via intervention/image

### 3. Système de rendez-vous

**Pour patients:**
```
Remplir formulaire:
- Name, age, téléphone
- Email
- Service demandé
- Raison (optional)
- Date souhaitée (optional)
```

**Pour administrateur:**
- Tableau RDV avec filtres
- Changer statut (en attente → confirmé → annulé)
- Exporter CSV
- Statistiques par service
- Notifications email client/admin

**Emails envoyés:**
1. Confirmation au patient
2. Notification admin
3. Email de confirmation après validation

### 4. Tarification

**Par service:**
- Designation (ex: "Accouchement normal")
- Montant en FCFA
- Type patient (normal/étudiant/urgence)
- Détails (inclusions/exclusions)

**Admin:**
- Interface CRUD tarifs
- Modification rapide montants
- Différenciation par type

### 5. Horaires d'ouverture

**Format:**
- Par service
- Par jour semaine (Lun-Dim)
- Heures ouverture/fermeture
- Note optionnelle (ex: "Urgences: 24/24")

**Client:**
- Affichage horaires service
- Indicateur si ouvert maintenant

### 6. Actualités et Blog

**Pour clients:**
- Articles avec image couverture
- Contenu riche (TipTap editor)
- Vidéos YouTube intégrées
- Catégories (nutrition, prévention, événements)
- Compteur vues
- Réactions (likes, love, wow, sad, angry)
- Temps de lecture estimé

**Admin:**
- Éditeur WYSIWYG (TipTap)
- Upload images
- Vidéos YouTube
- Scheduling publication
- Récit de publication
- Compteur vues

**Système likes:**
- Toggle like/unlike
- Plusieurs types réactions
- Stats par type
- Identifiant par IP + user_id

### 7. Système de contact

**Formulaire client:**
- Nom, email, téléphone
- Message libre
- Envoi email admin
- Confirmation client

**Admin:**
- Inbox messages
- Marquer lu/non-lu
- Répondre par email
- Archiver/supprimer

**Emails:**
- Notification admin (nouvelle personne)
- Confirmation client (email reçu)

### 8. Activitylog - Audit Trail

Package: **spatie/laravel-activitylog**

**Événements loggés:**
- Création/modification/suppression modèles
- Utilisateur responsable
- IP utilisateur
- Modifications (before/after)
- Timestamps

**Utilisation:**
```php
// Dans le modèle
use LogsActivity;

public function getActivitylogOptions(): LogOptions {
    return LogOptions::defaults()
        ->logAll()
        ->logFillable()
        ->setDescriptionForEvent(fn(string $eventName) => "Service {$eventName}");
}
```

**Viewing logs:**
```php
$logs = Activity::where('subject_type', 'App\Models\Service')->get();
```

---

## Emails

### Configuration

**Fichier:** `.env`
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=admin@hra-dschang.cm
MAIL_PASSWORD=app_specific_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=admin@hra-dschang.cm
MAIL_FROM_NAME="HRA Dschang"
```

### Classes Mailable

Location: `app/Mail/`

#### 1. PasswordResetMail

**Fichier:** `PasswordResetMail.php`
**Utilisé:** Reset mot de passe
**Destinataire:** User

**Variables:**
- `$token` - Token reset unique
- `$email` - Email utilisateur
- `$userName` - Prénom/Nom
- Lien reset avec expiration

**Vue email:** `resources/views/emails/auth/reset-password.blade.php`

#### 2. ConfirmationRdvPatient

**Utilisé:** Confirmer RDV au patient
**Destinataire:** Patient (email from rdv_request)

**Variables:**
- Date/heure rendez-vous
- Service sélectionné
- Numéro référence RDV

#### 3. NouveauRdvAdmin

**Utilisé:** Notifier admin de nouveau RDV
**Destinataire:** Admin (récupéré depuis config)

**Variables:**
- Info patient
- Service demandé
- Date souhaitée
- Lien vers tableau RDV admin

#### 4. NouveauMessageAdmin

**Utilisé:** Message contact soumis
**Destinataire:** Admin

**Variables:**
- Nom expéditeur
- Email expéditeur
- Message (preview 100 char)

#### 5. NouveauCompteUtilisateur

**Utilisé:** Création nouvel utilisateur admin
**Destinataire:** Nouvel admin

**Variables:**
- Email/password temporaire
- Lien connexion
- Instruction changement mot de passe

#### 6. RdvStatusChange

**Utilisé:** Changement statut RDV
**Destinataire:** Patient

**Variables:**
- Ancien statut → Nouveau statut
- Message de confirmation/annulation

### Envoi des emails dans les contrôleurs

```php
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;

// Envoi simple
Mail::to($user->email)->send(new PasswordResetMail($token, $user->email));

// Avec queue (asynchrone)
Mail::to($user->email)->queue(new PasswordResetMail($token, $user->email));

// Test local (Mail::mailer('log'))
// Les mails s'affichent dans storage/logs/laravel.log
```

### Layouts emails

**Blade layout:** `resources/views/emails/layout.blade.php`

Style:
- Header avec logo HRA
- Footer avec infos contact
- Styling Tailwind intégré
- Responsive design

---

## Guide d'Utilisation Admin

### Accès à l'interface admin

1. Accéder: `https://votre-domain.com/admin/login`
2. Saisir email admin
3. Saisir mot de passe
4. Cliquer "Connexion"

### Dashboard

À l'entrée, le dashboard affiche:
- **Statistiques principales**
  - Total services
  - Total médecins
  - Demandes RDV non traitées
  - Messages non lus

- **Graphiques**
  - RDV par service (pie chart)
  - Tendance RDV (line chart)
  - Articles récents

### Gestion des services

#### Créer service
1. Menu → Services
2. Bouton "+ Nouveau service"
3. Remplir formaulaire:
   - Nom service
   - Description
   - Icône Lucide (choix)
   - Tarif consultation
   - Ordre affichage

#### Modifier service
1. Cliquer service dans liste
2. Formulaire pré-rempli
3. Modifier et sauvegarder

#### Activer/Désactiver
- Switch dans la liste
- Service caché site public si inactif

#### Supprimer
- Bouton "Supprimer" en rouge
- Confirmation avant suppression

### Gestion des médecins

#### Ajouter médecin
1. Menu → Médecins
2. "+ Nouveau médecin"
3. Formulaire:
   - Nom complet
   - Spécialité
   - Diplômes
   - Bio/résumé
   - Langues (séparées virgules)
   - Photo (upload)
   - Services assignés (checkboxes)

#### Upload photo
- Format: JPG, PNG
- Dimension recommandée: 300x400px
- Redimensionné automatique à 300x400

#### Assigner services
- Checkboxes services
- Un médecin peut servir plusieurs services
- Patient voir médecin en consultant service

### Gestion actualités

#### Créer article
1. Menu → Actualités
2. "+ Nouvel article"
3. Éditeur riche (TipTap):
   - Titre article
   - Extrait (200 car max)
   - Contenu riche
   - Catégorie
   - Image couverture
   - Vidéo YouTube (optionnel)
   - Date publication

#### Éditer article
- Cliquer titre article
- Modifier contenu
- Sauvegarder

#### Publier/Dépublier
- Articles dépubliés non visibles clients
- Toggle publish dans liste
- Scheduling possible

#### Upload image
- Directement dans éditeur
- Drag & drop
- Auto-redimensionné

### Gestion RDV

#### Tableau RDV
- Liste demandes avec filtres
- Colonnes: Patient, Service, Date, Statut
- Tri par date/service/statut

#### Traiter demande
1. Cliquer demande
2. Lire infos patient
3. Changer statut:
   - **En attente** - À traiter
   - **Confirmé** - Email confirmation au patient
   - **Annulé** - Email annulation

#### Export
- Bouton "Exporter"
- Format CSV (ouvrir Excel)
- Toutes demandes ou filtrées

#### Statistiques
- Onglet "Stats"
- RDV par service (graphique)
- Tendance/période

### Gestion messages contact

#### Inbox
- List messages reçus
- Indicateur non lus (gras)
- Tri par date

#### Lire message
1. Cliquer message
2. Affichage complet
3. Options:
   - Marquer lu/non-lu
   - Répondre (email)
   - Supprimer

#### Répondre
- Bouton "Répondre"
- Remplir réponse
- Envoyer email client

### Gestion profil perso

#### Éditer profil
1. Menu → Mon profil
2. Formulaire:
   - Nom complet
   - Email
   - Téléphone
   - Photo

#### Changer mot de passe
1. Onglet "Sécurité"
2. Ancien mot de passe
3. Nouveau mot de passe x2
4. Sauvegarder

### Gestion utilisateurs (Super Admin)

#### Voir utilisateurs
- Menu → Utilisateurs
- Liste admin avec infos

#### Créer utilisateur
1. Bouton "+ Nouvel utilisateur"
2. Formulaire:
   - Email
   - Nom
   - Rôle (Super Admin / Admin)
   - Téléphone
   - Photo

3. Email envoyé avec password temporaire

#### Réinitialiser mot de passe
- Bouton "Réinitialiser mot de passe"
- Email envoyé user avec lien reset

#### Activer/Désactiver
- Toggle dans liste
- Utilisateur inactif ne peut pas se connecter

#### Supprimer
- Bouton "Supprimer"
- Soft delete (peut être restauré)

---

## API Reference

### Format réponses

**Succès (200):**
```json
{
  "success": true,
  "data": { /* données */ },
  "message": "Action réussie"
}
```

**Erreur (400/500):**
```json
{
  "success": false,
  "message": "Description erreur",
  "errors": { /* détails validation */ }
}
```

### Authentification API

Actuellement, la plupart des endpoints sont publics pour support frontend Inertia.

Pour endpoints protégés (ex: recherche):
```
Headers: Authorization: Bearer {token}
```

### Services

#### GET /api/services
```
Retourne tous les services actifs

Réponse:
[
  {
    "id": 1,
    "nom": "Pédiatrie",
    "slug": "pediatrie",
    "description": "Services pédiatriques...",
    "icon": "Baby",
    "tarif_consultation": 5000,
    "actif": true,
    "created_at": "2026-02-13T10:30:00Z"
  }
]
```

#### GET /api/services/{slug}
```
Retourne détails service + relations

Réponse:
{
  "id": 1,
  "nom": "Pédiatrie",
  "slug": "pediatrie",
  "description": "...",
  "icon": "Baby",
  "tarif_consultation": 5000,
  "horaires": [
    {
      "jour_semaine": "Lundi",
      "ouverture": "08:00",
      "fermeture": "17:00"
    }
  ],
  "tarifs": [
    {
      "designation": "Consultation générale",
      "montant": 5000,
      "type_patient": "normal"
    }
  ],
  "medecins": [
    {
      "id": 1,
      "nom": "Dr. Jean Médecin",
      "specialite": "Pédiatre"
    }
  ]
}
```

### Actualités

#### GET /api/actualites
```
Retourne articles publiés (paginated)

Query params:
- page: int (défaut: 1)
- per_page: int (défaut: 10)
- categorie: string (filtre optionnel)

Réponse:
{
  "data": [
    {
      "id": 1,
      "titre": "Conseils nutrition enfants",
      "slug": "conseils-nutrition-enfants",
      "extrait": "Les enfants ont besoin...",
      "image": "/storage/actualites/image.jpg",
      "categorie": "nutrition",
      "auteur": "Dr. Martin",
      "date_publication": "2026-02-17T14:30:00Z",
      "vues": 125,
      "likes_count": 42
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 45,
    "per_page": 10
  }
}
```

#### GET /api/actualites/{slug}
```
Retourne article complet + incrémente vues

Réponse:
{
  "id": 1,
  "titre": "...",
  "contenu": "<p>Contenu HTML...</p>",
  "video": "https://youtube.com/watch?v=...",
  "video_type": "youtube",
  "vues": 126,  // +1
  "likes_count": 42
}
```

### RDV

#### POST /api/rdv-requests
```
Créer demande rendez-vous

Body:
{
  "nom_patient": "Jean Pierre",
  "age": 28,
  "telephone": "+237695123456",
  "email": "jean@example.com",
  "service_id": 1,
  "motif": "Consultation générale",
  "date_souhaitee": "2026-02-25 14:00:00"  // optionnel
}

Réponse:
{
  "id": 120,
  "statut": "en_attente",
  "created_at": "2026-02-17T15:45:00Z",
  "message": "Demande enregistrée. Confirmation par email."
}
```

### Messages contact

#### POST /api/contacts
```
Envoyer message contact

Body:
{
  "nom": "Marie Dupont",
  "email": "marie@example.com",
  "telephone": "+237695123456",  // optionnel
  "message": "Demande information..."
}

Réponse:
{
  "id": 45,
  "created_at": "2026-02-17T16:00:00Z",
  "message": "Message reçu. Nous vous répondrons bientôt."
}
```

### Recherche

#### POST /api/search/global
```
Recherche multi-modèles (authentifiée)

Headers: Authorization: Bearer {token}

Body:
{
  "query": "pediatrie"
}

Réponse:
{
  "services": [
    {
      "id": 1,
      "nom": "Pédiatrie",
      "type": "service"
    }
  ],
  "medecins": [
    {
      "id": 5,
      "nom": "Dr. Jean Martin",
      "type": "medecin"
    }
  ],
  "actualites": [
    {
      "id": 12,
      "titre": "Conseils pédiatriques",
      "type": "actualite"
    }
  ]
}
```

---

## Configuration et Environnement

### Fichiers configuration clés

**config/app.php**
- APP_NAME, APP_ENV, APP_DEBUG
- APP_KEY (encryption)
- APP_URL
- Timezone (UTC recommandé)
- Locale (en_US par défaut)

**config/database.php**
- Connexion SQLite (dev) ou MySQL (prod)
- Connection details
- Redis cache (optionnel)

**config/auth.php**
- Guards (web = sessions)
- Providers
- Passwords reset (60 min expiration)

**config/mail.php**
- Mailer SMTP
- From address
- Queue driver

**config/permission.php**
- Table names pour rôles/permissions
- Cache TTL

### Commandes Artisan utiles

```bash
# Migrations
php artisan migrate              # Exécuter les migrations
php artisan migrate:refresh      # Reset + rejeu
php artisan migrate:rollback     # Annuler dernière batch

# Seeders
php artisan db:seed                  # Exécuter tous seeders
php artisan db:seed --class=AdminSeeder  # Seeder spécifique

# Cache
php artisan config:cache        # Cacher configuration
php artisan config:clear        # Vider cache config
php artisan route:cache         # Cacher routes
php artisan view:cache          # Pré-compiler vues

# Queue
php artisan queue:listen        # Écouter queue jobs

# Tinker (REPL)
php artisan tinker              # Interactive shell PHP

# Storage
php artisan storage:link        # Lier storage public

# Test
php artisan test                # Exécuter tests PHPUnit
```

---

## Dépannage

### Problèmes courants

#### 1. "SQLSTATE[HY000]: General error"

**Cause:** SQLite incorrectement configuré

**Solution:**
```bash
touch database/database.sqlite
php artisan migrate
```

#### 2. "Class not found" après composer install

**Cause:** Autoloader non recompilé

**Solution:**
```bash
composer dump-autoload
```

#### 3. Permissions fichiers storage

**Cause:** Laravel ne peut écrire dans storage

**Solution:**
```bash
chmod -R 755 storage bootstrap/cache
sudo chown -R www-data:www-data storage
```

#### 4. Erreur upload fichiers

**Cause:** Disque storage mal configuré

**Fichier:** `.env`
```env
FILESYSTEM_DISK=public  # ou local
```

Ensuite:
```bash
php artisan storage:link
```

#### 5. Emails n'arrivent pas

**Vérifier:**
```bash
# Queue listening?
php artisan queue:listen

# Configuration SMTP?
# Test mode: MAIL_MAILER=log

# Vérifier logs
tail -f storage/logs/laravel.log
```

#### 6. "419 Page Expired"

**Cause:** CSRF token expiré

**Solution:**
- Session timeout trop court
- Recharger page
- Vérifier CSRF middleware dans web.php

#### 7. Erreur "The resource path is not defined"

**Cause:** Vite assets pas compilés

**Solution:**
```bash
npm run build       # Production
npm run dev         # Development
```

#### 8. Permission denied storage/logs

```bash
chmod 777 storage/logs
```

#### 9. Erreur authentification

```php
// Vérifier
php artisan tinker
$user = User::find(1);  // Existe?
Hash::check('password', $user->password)  // Valid?
```

#### 10. Roles/Permissions ne fonctionnent pas

```bash
php artisan cache:clear
php artisan config:clear
php artisan permission:create-permission view_users
```

---

## Maintenance et Monitoring

### Backups

```bash
# Backup database
mysqldump -u root -p hra_dschang > backup_$(date +%Y%m%d).sql

# Backup storage files
tar -czf storage_backup_$(date +%Y%m%d).tar.gz storage/app/public/
```

### Logs

**Location:** `storage/logs/laravel.log`

```bash
# Voir erreurs temps réel
tail -f storage/logs/laravel.log

# Filtrer par ERROR
grep ERROR storage/logs/laravel.log
```

### Performance monitoring

```php
// Dans controller
$startTime = microtime(true);

// ... code ...

$duration = microtime(true) - $startTime;
\Log::info("Query duration: {$duration}ms");
```

### Activity audit

```php
// Voir changements d'une ressource
$logs = \Spatie\Activitylog\Models\Activity::where('subject_type', 'App\Models\Service')
    ->where('subject_id', 1)
    ->get();

foreach ($logs as $log) {
    echo $log->description . " by " . $log->causer->name . " at " . $log->created_at;
}
```

---

## Checklist Production

- [ ] `.env` configuré (APP_DEBUG=false)
- [ ] APP_KEY générée
- [ ] Database configurée et migrée
- [ ] Storage link créé (`php artisan storage:link`)
- [ ] Fichiers uploadables testés
- [ ] Emails testés avec vrais credentials SMTP
- [ ] HTTPS SSL activé
- [ ] Backup strategy en place
- [ ] Logs monitoring configuré
- [ ] Cache drivers activés
- [ ] Routes cachées (`php artisan route:cache`)
- [ ] Config cachée (`php artisan config:cache`)
- [ ] Seeders exécutés (admin user créé)
- [ ] Permissions initiales assignées
- [ ] Sitemap généré (`php artisan sitemap:generate`)

---

## Support et Escalade

Pour signaler des bugs ou demander des améliorations:

1. **Email:** admin@hra-dschang.cm
2. **Problème urgent:** Contact support IT
3. **Feature request:** Documentation via Git issues

---

## Historique des versions

### v1.0.0 (17 février 2026)
- ✅ Release initiale
- ✅ Tous services médicaux
- ✅ Équipe médicale
- ✅ Système RDV complet
- ✅ Blog/Actualités avec vidéos
- ✅ Système likes/réactions
- ✅ Formulaire contact
- ✅ Admin panel sécurisé
- ✅ Rôles et permissions
- ✅ Activity logging

---

**Document compilé le:** 17 février 2026  
**Version documentation:** 1.0  
**Prochaine révision:** À déterminer
