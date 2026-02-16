# Résumé du Projet HRA Dschang Website

**Date:** 14 février 2026  
**Projet:** Site web de l'Hôpital HRA Dschang (Cameroun)  
**Technologies:** Laravel 12, Vue 3, Inertia.js, Tailwind CSS 4, Vite

---

## 📋 Vue d'ensemble du projet

Le projet est un site web interactif pour l'Hôpital HRA Dschang au Cameroun. C'est une application **web moderne full-stack** avec un backend Laravel API et un frontend Vue 3 utilisant Inertia.js pour un rendu côté serveur.

### Objectif
Créer une plateforme professionnelle permettant aux patients de:
- Consulter les services médicaux disponibles
- Voir l'équipe médicale (médecins)
- Prendre rendez-vous
- Consulter les tarifs
- Contacter l'hôpital
- Accéder à des informations (FAQ, horaires, etc.)

---

## 🏗️ Architecture technique

### Stack technologique
- **Backend:** Laravel 12.x (Framework PHP)
- **Frontend:** Vue 3 + Inertia.js v2 pour SSR
- **Styling:** Tailwind CSS 4.0
- **Build tool:** Vite 7
- **Icons:** Lucide Vue 3
- **Database:** SQLite (dev) / à configurer production
- **ORM:** Eloquent (modèles Laravel)
- **Frontend utilities:** VueUse v14 (Composition API helpers)

### Structure des dossiers clés
```
app/
├── Http/
│   └── Controllers/
│       ├── Api/
│       │   ├── ServiceController.php
│       │   ├── RdvRequestController.php
│       │   └── ContactController.php
│       └── Controller.php (base)
├── Models/
│   ├── Service.php
│   ├── Medecin.php
│   ├── RdvRequest.php
│   ├── Contact.php
│   ├── Horaire.php
│   ├── Tarif.php
│   └── User.php
└── Providers/
    └── AppServiceProvider.php

database/
├── migrations/ (8 migrations créées)
├── seeders/ (ServiceSeeder, MedecinSeeder, etc.)
└── factories/

resources/
└── js/
    ├── Pages/ (composants Vue pour les pages)
    │   ├── Home.vue
    │   ├── Services/
    │   │   ├── Index.vue
    │   │   └── Show.vue
    │   ├── Equipe/ (médecins)
    │   │   ├── Index.vue
    │   │   └── Show.vue
    │   ├── RDV/
    │   │   └── Create.vue
    │   ├── Tarifs/
    │   │   └── Index.vue
    │   ├── Contact/
    │   │   └── Index.vue
    │   └── FAQ.vue
    ├── Components/ (composants réutilisables)
    │   ├── Button.vue
    │   ├── Alert.vue
    │   └── ServiceCard.vue
    └── Layouts/
        └── AppLayout.vue (layout principal)

routes/
├── api.php (routes API REST)
└── web.php (routes web avec Inertia)

config/
└── [fichiers de configuration Laravel]
```

---

## 🗄️ Structure de la Base de Données

### Tables créées via migrations

#### 1. **services** (Services médicaux)
```sql
- id (PK)
- nom (string) - Ex: "Pédiatrie"
- slug (string, unique) - Pour URLs
- description (text)
- icon (string) - Nom icône Lucide
- tarif_consultation (integer) - FCFA
- actif (boolean)
- ordre (integer) - Pour tri affichage
- created_at, updated_at
```

#### 2. **medecins** (Équipe médicale)
```sql
- id (PK)
- nom (string)
- slug (string, unique)
- specialite (string) - Ex: "Cardiologue"
- diplomes (text) - CV/qualifications
- photo (string) - Chemin image
- bio (text)
- langues (string) - Ex: "Français, Anglais"
- actif (boolean)
- created_at, updated_at
```

#### 3. **medecin_service** (Pivot - Many-to-many)
```sql
Relie médecins et services (médecin travaille dans plusieurs services)
```

#### 4. **horaires** (Horaires d'ouverture par service)
```sql
- id (PK)
- service_id (FK → services)
- jour_semaine (enum) - Lundi à Dimanche
- ouverture (time) - Ex: 08:00
- fermeture (time) - Ex: 17:00
- note (string) - Ex: "Urgences uniquement"
- created_at, updated_at
- Unique constraint: [service_id, jour_semaine]
```

#### 5. **tarifs** (Tarifs par service)
```sql
- id (PK)
- service_id (FK → services)
- designation (string) - Ex: "Accouchement normal"
- montant (integer) - FCFA
- type_patient (enum) - normal, etudiant, urgence
- details (text) - Ce qui est inclus/non inclus
- created_at, updated_at
```

#### 6. **rdv_requests** (Demandes de rendez-vous)
```sql
- id (PK)
- nom_patient (string)
- age (integer, nullable)
- telephone (string) - Format: +237XXXXXXXXX
- service_id (FK → services)
- motif (text) - Raison de consultation
- statut (enum) - en_attente, confirme, annule
- confirmation_whatsapp (boolean)
- date_souhaitee (timestamp)
- created_at, updated_at
```

#### 7. **contacts** (Messages de formulaire de contact)
```sql
- id (PK)
- nom (string)
- email (string)
- telephone (string, nullable)
- message (text)
- lu (boolean) - Lu par admin
- created_at, updated_at
```

#### 8. **users** (Administrateurs - Laravel standard)
Tables standards: users, password_reset_tokens, cache, jobs, personal_access_tokens

---

## 📝 Modèles Eloquent et leurs Méthodes

### **Service.php**
```php
Relations:
- hasMany('horaires')
- hasMany('tarifs')
- hasMany('rdvRequests')
- belongsToMany('medecins') via medecin_service

Scopes:
- actif() - Filtre les services actifs
- ordonne() - Trie par colonne 'ordre'
```

### **Medecin.php**
```php
Relations:
- belongsToMany('services') via medecin_service

Scopes:
- actif() - Filtre les médecins actifs
- parSpecialite($specialite) - Filtre par spécialité
```

### **RdvRequest.php**
```php
Relations:
- belongsTo('service')

Fillable fields:
- nom_patient, age, telephone, service_id, motif, 
  confirmation_whatsapp, date_souhaitee
```

### **Contact.php**
```php
Fillable fields:
- nom, email, telephone, message
```

### **Horaire.php** et **Tarif.php**
- Modèles basiques avec HasFactory (à compléter si besoin)

---

## 🛣️ Routes et Endpoints

### Routes Web (Inertia - Côté serveur rendu)

| Route | Méthode | Page | Description |
|-------|---------|------|-------------|
| `/` | GET | Home.vue | Page d'accueil avec services listés |
| `/services` | GET | Services/Index.vue | Liste tous les services |
| `/services/{slug}` | GET | Services/Show.vue | Détail d'un service |
| `/equipe` | GET | Equipe/Index.vue | Liste des médecins |
| `/equipe/{slug}` | GET | Equipe/Show.vue | Profil d'un médecin |
| `/tarifs` | GET | Tarifs/Index.vue | Affiche tous les tarifs par service |
| `/rendez-vous` | GET | RDV/Create.vue | Formulaire de RDV |
| `/contact` | GET | Contact/Index.vue | Formulaire de contact |
| `/faq` | GET | FAQ.vue | FAQ/Aide |

**Note:** Routes doivent être en ordre spécifique pour éviter les conflits (ex: `/equipe/{slug}` avant `/services/{slug}`)

### Routes API (JSON)

| Route | Méthode | Contrôleur | Description |
|-------|---------|-----------|-------------|
| `/api/services` | GET | ServiceController@index | Liste services avec relations |
| `/api/services/{slug}` | GET | ServiceController@show | Détail service |
| `/api/rdv-requests` | POST | RdvRequestController@store | Créer demande RDV |
| `/api/contacts` | POST | ContactController@store | Créer message contact |

---

## 🎯 Contrôleurs API

### **ServiceController.php**
```php
- index(): Retourne tous les services actifs avec horaires, tarifs, médecins
- show($slug): Retourne un service spécifique par slug avec relations
```

### **RdvRequestController.php**
```php
- store(Request $request):
  - Validation: nom_patient (min 3), telephone (+237), service_id (exists)
  - Retourne redirect().back() avec message success
```

### **ContactController.php**
```php
- store(Request $request):
  - Validation: nom (min 3), email, message (min 10)
  - Retourne redirect().back() avec message success
```

---

## 🎨 Composants Vue

### **Layouts/AppLayout.vue**
- Layout principal de toutes les pages
- Contient navbar, footer, structure globale

### **Pages/Home.vue** (886 lignes)
- Page d'accueil
- Animation des statistiques avec Intersection Observer
- Affiche statistiques animées (patients, services, professionnels)
- Affichage des services
- Call-to-action RDV

### **Pages/RDV/Create.vue** (423 lignes)
- Formulaire de demande de rendez-vous
- Validation client pour téléphone (+237XXXXXXXXX)
- Validation formulaire complet
- Intégration Inertia.js useForm()
- Gestion erreurs et succès

### **Pages/Tarifs/Index.vue**
- Affiche tarifs groupés par service

### **Pages/Equipe/Index.vue**
- Liste des médecins avec filtrage par spécialité

### **Pages/Equipe/Show.vue**
- Profil détaillé du médecin

### **Pages/Services/Index.vue**
- Liste tous les services

### **Pages/Services/Show.vue**
- Détail d'un service avec horaires et tarifs

### **Pages/Contact/Index.vue**
- Formulaire de contact

### **Pages/FAQ.vue**
- Page FAQ

### **Components/Button.vue**
- Bouton réutilisable

### **Components/Alert.vue**
- Alerte réutilisable (success, error, warning)

### **Components/ServiceCard.vue**
- Carte pour afficher un service

---

## 🌱 Seeders (Données d'initialisation)

### **ServiceSeeder.php**
8 services médicaux sont créés lors du démarrage:
1. Pédiatrie (consultation 5000 FCFA)
2. Maternité (consultation 5000 FCFA)
3. Cardiologie (consultation 8000 FCFA)
4. Chirurgie Générale (consultation 10000 FCFA)
5. Urgences (consultation 7500 FCFA)
6. Médecine Générale (consultation 5000 FCFA)
7. Laboratoire (0 FCFA - tarifs par analyse)
8. Radiologie (0 FCFA - tarifs par examen)

Chaque service a:
- Icon Lucide
- Description détaillée
- Tarif de consultation
- Flag actif
- Ordre d'affichage

### **MedecinSeeder.php**, **HoraireSeeder.php**, **TarifSeeder.php**
À consulter pour voir les données d'exemple créées

---

## ⚙️ Configuration importante

### **vite.config.js**
- Plugins: laravel, vue, tailwindcss
- Port dev: 5173

### **composer.json**
```json
"require": {
  "laravel/framework": "^12.0",
  "inertiajs/inertia-laravel": "^2.0",
  "laravel/sanctum": "^4.0"
}
```

### **package.json**
```json
"dependencies": {
  "vue": "^3.5.28",
  "@inertiajs/vue3": "^2.3.14",
  "tailwindcss": "^4.0.0",
  "@vitejs/plugin-vue": "^6.0.4"
}
```

### **Scripts disponibles**
```bash
# Dev
npm run dev              # Démarre Vite en dev
php artisan serve       # Démarre serveur Laravel
php artisan migrate     # Applique migrations
php artisan db:seed     # Exécute seeders

# Production
npm run build           # Build Vite pour production
composer run dev        # Lance tout en concurrent
```

---

## 🎨 Design et UI/UX

### Caractéristiques de design
- ✅ Tailwind CSS 4 (responsive)
- ✅ Icônes Lucide Vue (32+ icônes utilisées)
- ✅ Animations fluides (Intersection Observer)
- ✅ Numérotation téléphones: Format +237 (Cameroun)
- ✅ Responsive design

### Palette et conventions
- Langue: Français
- Format monnaies: FCFA
- Format dates: ISO (pour base de données)
- Slugs: Générer avec `str_slug()` ou `Str::slug()`

---

## 🔄 Flux actuellement implémentés

### 1. Consultation des services
- Utilisateur visite `/services`
- Page affiche tous les services actifs, ordonnés
- Chaque service affiche icon, tarif de consultation, description
- Clic sur service → `/services/{slug}` → Affiche détails + horaires + tarifs + médecins

### 2. Recherche médecins
- Utilisateur visite `/equipe`
- Page affiche médecins avec filtrage par spécialité
- Clic sur médecin → `/equipe/{slug}` → Profil complet + services where médecin travaille

### 3. Consultation des tarifs
- Utilisateur visite `/tarifs`
- Affiche tous les services avec leurs tarifs groupés
- Triés par service

### 4. Demande de rendez-vous
- Utilisateur visite `/rendez-vous`
- Remplir formulaire: nom, âge, téléphone (+237), service, motif
- POST vers `/api/rdv-requests` avec validation
- Message confirmation WhatsApp optionnel

### 5. Contact
- Utilisateur visite `/contact`
- Remplir formulaire: nom, email, téléphone, message
- POST vers `/api/contacts`
- Enregistrement dans DB

### 6. Page d'accueil
- Affiche statistiques animées
- Affiche services en vedette
- CTA pour RDV

### 7. FAQ
- Page statique (à développer si needed)

---

## ⚠️ Points importants à noter

### Ordre des routes
Les routes doivent être en cet ordre dans `web.php`:
1. `/equipe` → avant `/equipe/{slug}`
2. `/equipe/{slug}` → avant `/services/{slug}` 
3. `/services` → avant `/services/{slug}`

Sinon les patterns se confondent!

### Validation téléphone
- Format: `+237XXXXXXXXX` (Cameroun)
- Regex: `^\+237[0-9]{9}$`
- Utilisé dans RDV et Contact

### Points concernant l'API
- RdvRequestController et ContactController font `redirect()->back()` ce qui n'est pas standard pour une API JSON
- À corriger si vous avez besoin de réponses JSON pures

### Modèles incomplets
- Horaire.php: Vide (juste HasFactory)
- Tarif.php: Vide (juste HasFactory)
- À compléter selon le design si relations needed

---

## 📦 Comment démarrer

```bash
# 1. Installation dépendances
composer install
npm install

# 2. Setup
php artisan key:generate
php artisan migrate
php artisan db:seed

# 3. Dev
php artisan serve
npm run dev
```

Site accessible à: `http://localhost:8000`
Vite dev server: `http://localhost:5173`

---

## 🔐 Authentification

Actuellement: **Aucune authentification implémentée**

La base est là (users table, Sanctum) mais routes web accessible publiquement. 

À faire si needed:
- Système login pour admin
- Protéger certaines pages
- Panel d'administration pour gérer services, tarifs, messages

---

## 📱 Fonctionnalités manquantes / À développer

- [ ] Panel d'administration (CRUD services, médecins, tarifs)
- [ ] Système d'authentification
- [ ] Email notifications (nouvelles demandes RDV/contact)
- [ ] Intégration WhatsApp API
- [ ] Système de paiement en ligne
- [ ] Calendar/Booking système pour RDV
- [ ] Multi-langue (FR/EN)
- [ ] Sitemap et SEO
- [ ] Analytics

---

## 🎯 Conventions de code à respecter

### Backend (Laravel/PHP)
- Noms modèles: Singulier, PascalCase (Service, Medecin)
- Noms tables: Pluriel, snake_case (services, medecins)
- Noms slug: kebab-case (dr-jean-paul-foka)
- Scopes: Commencer par "scope", camelCase

### Frontend (Vue)
- Noms composants: PascalCase (ServiceCard.vue)
- Noms fichiers: PascalCase pour Pages et Components
- Props: camelCase
- Événements: camelCase

### Base de données
- Montants: En FCFA (entiers)
- Dates: ISO format (YYYY-MM-DD)
- Booléens: `actif`, `lu`, `confirmation_whatsapp`

---

## 📋 Structure des requêtes API

### POST /api/rdv-requests
```json
{
  "nom_patient": "Jean Dupond",
  "age": 35,
  "telephone": "+237677123456",
  "service_id": 1,
  "motif": "Suivi cardiaque",
  "confirmation_whatsapp": true
}
```

### POST /api/contacts
```json
{
  "nom": "Alice Martin",
  "email": "alice@example.com",
  "telephone": "+237677123456",
  "message": "J'aimerais plus d'informations sur vos services"
}
```

---

## ✅ Checklist pour reprendre le projet

- [ ] Lire ce résumé complètement
- [ ] Consulter les migrations pour comprendre le modèle de données
- [ ] Lancer `php artisan migrate:fresh --seed` pour initialiser
- [ ] Vérifier les routes: `php artisan route:list`
- [ ] Tester les endpoints API avec Postman/Insomnia
- [ ] Comprendre le flux Inertia.js (server-side rendering)
- [ ] Comparer le design existant avec maquettes/spécifications
- [ ] Identifier quels composants Vue sont partiels ou incomplets
- [ ] Planifier les prochaines étapes avec le client

---

**Fin du résumé. Bonne continuation du développement!** 🚀
