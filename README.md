# 🏥 HRA Dschang Website - Plateforme Médicale Moderne

![Version](https://img.shields.io/badge/version-1.0.0-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Laravel](https://img.shields.io/badge/Laravel-12.x-red)
![Vue.js](https://img.shields.io/badge/Vue.js-3.5-green)
![Build Status](https://img.shields.io/badge/build-passing-success)

> Une plateforme web moderne et professionnelle pour l'Hôpital HRA Dschang (Cameroun) permettant une gestion complète des services médicaux, des rendez-vous et de la relation patient.

---

## 📋 Table des Matières

- [À Propos](#-à-propos)
- [Captures d'Écran](#-captures-décran)
- [Caractéristiques](#-caractéristiques)
- [Stack Technologique](#-stack-technologique)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Utilisation](#-utilisation)
- [Structure du Projet](#-structure-du-projet)
- [Contribution](#-contribution)
- [Licences & Crédits](#-licences--crédits)

---

## 🏢 À Propos

**HRA Dschang Website** est une application web full-stack développée pour l'Hôpital HRA Dschang, au Cameroun. Cette plateforme permet aux patients et aux administrateurs de :

- **Pour les Patients** : Consulter les services, voir les médecins, prendre rendez-vous, voir les tarifs
- **Pour l'Administration** : Gérer les services, les horaires, les tarifs, les rendez-vous et les actualités

Le projet utilise les dernières technologies web modernes pour offrir une expérience utilisateur fluide et réactive.

### 🎯 Objectifs Principaux

✅ Plateforme interactive et responsif  
✅ Gestion complète des appointments médicaux  
✅ Système d'actualités et d'informations  
✅ Système de tarification et d'horaires  
✅ Administration intuitives et sécurisée  
✅ Optimisé pour le SEO et les moteurs de recherche

---

## 📸 Captures d'Écran

### Page d'Accueil
![Home Page](docs/Captures%20d'écran/capture%20home.png)
*Page d'accueil avec navigation et vue d'ensemble des services*

### Authentification
![Login Page](docs/Captures%20d'écran/capture%20login.png)
*Interface de connexion sécurisée*

### Services Médicaux
![Services Page](docs/Captures%20d'écran/capture%20services.png)
*Liste des services disponibles avec détails*

### Équipe Médicale
![Doctors Page](docs/Captures%20d'écran/captur%20médecin.png)
*Présentation des médecins et spécialistes*

### À Propos
![About Page](docs/Captures%20d'écran/capture%20Apropos.png)
*Information sur l'hôpital et ses valeurs*

---

## ⚡ Caractéristiques

### Pour les Utilisateurs Patients

- 🏥 **Consulter les Services** - Découvrez tous les services médicaux disponibles
- 👨‍⚕️ **Voir les Médecins** - Consultez les profils des médecins spécialistes
- 📅 **Prendre Rendez-Vous** - Système de réservation en ligne intuitif
- 💰 **Consulter les Tarifs** - Tarification claire et transparente
- 📞 **Contacter l'Hôpital** - Formulaire de contact direct
- 📚 **FAQ et Informations** - Questions fréquemment posées et guides
- ⏰ **Horaires** - Horaires d'ouverture et disponibilités

### Pour les Administrateurs

- 🔐 **Authentification Sécurisée** - Système de permissions avancé
- 📊 **Tableau de Bord** - Vue d'ensemble et statistiques
- 🏥 **Gestion des Services** - CRUD complet des services médicaux
- 👨‍⚕️ **Gestion des Médecins** - Profils et spécialités
- 📋 **Gestion des Rendez-Vous** - Suivi et gestion des appointments
- 💰 **Tarification** - Gestion des prix et forfaits
- ⏰ **Horaires** - Configuration des horaires d'ouverture
- 📰 **Actualités** - Publication et gestion des news
- 📧 **Notifications** - Emails automatisés
- 📝 **Logs d'Activité** - Suivi complet des modifications

---

## 🛠 Stack Technologique

### Backend
- **Framework** : [Laravel 12.x](https://laravel.com) - Framework PHP moderne
- **ORM** : Eloquent - Gestion de base de données élégante
- **Auth** : Laravel Sanctum - API authentication sécurisée
- **Permissions** : Spatie Laravel Permission - Gestion des rôles et permissions
- **Activity Logging** : Spatie Activity Log - Audit trail complet
- **Sitemap** : Spatie Laravel Sitemap - Génération automatique de sitemap
- **SEO** : Artesaos SEO Tools - Optimisation pour les moteurs de recherche

### Frontend
- **Framework** : [Vue.js 3.5](https://vuejs.org) - Framework JavaScript réactif
- **Adapter** : [Inertia.js v2](https://inertiajs.com) - Rendu côté serveur avec Vue
- **CSS** : [Tailwind CSS 4.0](https://tailwindcss.com) - Utility-first CSS framework
- **Icons** : [Lucide Vue 3](https://lucide.dev) - Icônes SVG modernes
- **Build Tool** : [Vite 7](https://vitejs.dev) - Build bundler ultra-rapide
- **Utilities** : [VueUse v14](https://vueuse.org) - Vue Composition API utilities
- **HTTP** : Axios - Requêtes HTTP client

### Base de Données
- **Development** : SQLite
- **Production** : MySQL / PostgreSQL (configurable)

### Outils et Services
- **Testing** : PHPUnit, Pest
- **Code Quality** : Laravel Pint
- **API Versioning** : Ziggy Routes

---

## 📦 Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- **PHP** >= 8.2
- **Composer** (gestionnaire de dépendances PHP)
- **Node.js** >= 18.x et **npm**
- **Git** (pour cloner le projet)
- **SQLite** ou une base de données compatible (MySQL, PostgreSQL)

### Vérifier les versions

```bash
php --version       # PHP >= 8.2
composer --version  # Composer récent
node --version      # Node.js >= 18
npm --version       # npm >= 9
```

---

## 🚀 Installation

### 1. Cloner le Repository

```bash
git clone https://github.com/votre-username/hrad-site.git
cd hrad-site
```

### 2. Installation des Dépendances

```bash
# Installer les dépendances PHP
composer install

# Installer les dépendances JavaScript
npm install
```

### 3. Configuration Environnementale

```bash
# Copier le fichier .env.example
cp .env.example .env

# Générer une clé d'application
php artisan key:generate
```

### 4. Migration de la Base de Données

```bash
# Exécuter les migrations
php artisan migrate

# (Optionnel) Seed la base de données avec des données de test
php artisan db:seed
```

### 5. Build Front-End

```bash
# Build des assets (mode production)
npm run build

# Ou pour le développement avec hot reload
npm run dev
```

---

## ⚙️ Configuration

### Fichier .env Crucial

Assurez-vous que votre fichier `.env` contient les configurations suivantes :

```env
APP_NAME=HRA-Dschang
APP_ENV=local
APP_KEY=base64:GENERATED_KEY_HERE
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# Mail Configuration (pour les notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@hrad-hospital.cm

# App
APP_TIMEZONE=Africa/Douala
```

### Créer la Base de Données SQLite

```bash
# Vérifier que la base de données existe ou la créer
touch database/database.sqlite
```

---

## 🎯 Utilisation

### Démarrer le Serveur Développement

```bash
# Terminal 1 - Serveur Laravel
php artisan serve

# Terminal 2 - Vite dev server (pour le hot reload)
npm run dev
```

L'application sera accessible sur `http://localhost:8000`

### Accès à l'Administration

1. Naviguez vers `/admin`
2. Connectez-vous avec les identifiants d'administrateur
3. Utilisez le tableau de bord pour gérer le contenu

### Commandes Artisan Utiles

```bash
# Migrations
php artisan migrate              # Exécuter les migrations
php artisan migrate:rollback     # Rollback dernière migration
php artisan migrate:fresh        # Fresh install (destructeur!)

# Seeding
php artisan db:seed              # Exécuter tous les seeders
php artisan db:seed --class=ServiceSeeder  # Seeder spécifique

# Cache
php artisan cache:clear          # Vider le cache
php artisan route:clear          # Vider le cache des routes
php artisan config:clear         # Vider le cache de configuration

# Assets
php artisan storage:link         # Lier le dossier storage public

# Optimisations
php artisan optimize              # Optimiser l'application
php artisan sitemap:generate     # Générer la sitemap XML
```

---

## 📁 Structure du Projet

```
hrad-site/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Contrôleurs métier
│   │   ├── Middleware/           # Middlewares (auth, permissions)
│   │   └── Requests/             # Form Request Validation
│   ├── Models/                   # Modèles Eloquent
│   │   ├── User.php
│   │   ├── Medecin.php
│   │   ├── Service.php
│   │   ├── RdvRequest.php
│   │   ├── Tarif.php
│   │   ├── Horaire.php
│   │   ├── Contact.php
│   │   ├── Actualite.php
│   │   └── ActualiteLike.php
│   ├── Mail/                     # Mailable classes (emails)
│   ├── Traits/                   # Traits réutilisables
│   └── Providers/                # Service Providers
│
├── resources/
│   ├── js/
│   │   ├── Pages/                # Pages Vue (routes principales)
│   │   ├── Components/           # Composants réutilisables
│   │   ├── Layouts/              # Layouts (AppLayout)
│   │   └── app.js                # Point d'entrée principal
│   ├── css/
│   │   └── app.css               # Styles globaux
│   └── views/
│       └── app.blade.php         # Template principal
│
├── routes/
│   ├── web.php                   # Routes web (Inertia)
│   ├── api.php                   # Routes API
│   └── console.php               # Commandes console
│
├── database/
│   ├── migrations/               # Fichiers de migrations
│   ├── seeders/                  # Fichiers de seeding
│   └── factories/                # Model factories
│
├── config/
│   ├── app.php                   # Configuration application
│   ├── database.php              # Configuration DB
│   ├── permission.php            # Configuration permissions
│   ├── seotools.php              # Configuration SEO
│   └── ...
│
├── public/
│   ├── storage/                  # Stockage accessible publiquement
│   ├── images/                   # Images statiques
│   ├── videos/                   # Vidéos
│   └── index.php                 # Point d'entrée
│
├── storage/
│   ├── app/                      # Application storage
│   ├── framework/                # Framework cache
│   └── logs/                     # Fichiers logs
│
├── tests/                        # Tests unitaires et fonctionnels
│   ├── Feature/
│   └── Unit/
│
├── docs/                         # Documentation du projet
│   ├── DEVELOPER_GUIDE.md
│   ├── PROJECT_SUMMARY.md
│   ├── INSTALLATION_RAPIDE.md
│   └── Captures d'écran/
│
├── .env.example                  # Template de configuration
├── .gitignore                    # Git ignore rules
├── composer.json                 # Dépendances PHP
├── package.json                  # Dépendances Node.js
├── vite.config.js                # Configuration Vite
├── tailwind.config.js            # Configuration Tailwind CSS
└── README.md                     # Ce fichier
```

---

## 🔐 Sécurité

### Points Clés de Sécurité

- ✅ **CSRF Protection** - Tokens CSRF automatiques sur tous les formulaires
- ✅ **SQL Injection Prevention** - Utilisation d'Eloquent et prepared statements
- ✅ **XSS Protection** - Échappement automatique des templates Vue
- ✅ **Authentication** - Laravel Sanctum pour les API
- ✅ **Authorization** - Spatie Laravel Permission pour les rôles/permissions
- ✅ **Rate Limiting** - Protection contre les attaques par force brute
- ✅ **HTTPS** - À activer en production

### Recommandations

```bash
# Entrer en mode production
APP_ENV=production
APP_DEBUG=false

# Compiler les assets
npm run build

# Optimiser l'application
php artisan optimize
php artisan config:cache
php artisan route:cache
```

---

## 🧪 Tests

### Exécuter les Tests

```bash
# Tous les tests
php artisan test

# Tests spécifique
php artisan test tests/Feature/UserTest.php

# Avec couverture de code
php artisan test --coverage

# Format Pest
./vendor/bin/pest
```

### Créer un Test

```bash
# Feature test
php artisan make:test UserTest

# Unit test
php artisan make:test UserTest --unit

# Test model factory
php artisan make:factory UserFactory
```

---

## 📝 Conventions de Code

### Naming Conventions

```php
// Classes
class UserController       // Singular + Controller
class CreateUserRequest    // Verb + Noun + Request

// Méthodes
public function store()    // RESTful verbs
public function show($id)

// Variables
$user = User::find($id);   // Singular
$users = User::all();      // Plural
$isActive = true;          // Boolean prefix
```

### Code Style

Le projet suit les standards PSR-12. Vérifiez avec Laravel Pint :

```bash
# Vérifier le style
php artisan pint --check

# Fixer automatiquement
php artisan pint
```

---

## 🚢 Déploiement

### Production Checklist

- [ ] Vérifier `APP_ENV=production` et `APP_DEBUG=false`
- [ ] Configurer une base de données production (MySQL/PostgreSQL)
- [ ] Configurer les variables MAIL
- [ ] Générer des clés SSL (HTTPS)
- [ ] Configurer un domaine
- [ ] Mettre en cache les configurations :
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```
- [ ] Optimiser l'autoloader Composer :
  ```bash
  composer install --optimize-autoloader --no-dev
  ```

### Hébergement Recommandé

- 🟢 Heroku
- 🟢 DigitalOcean App Platform
- 🟢 Vercel
- 🟢 AWS
- 🟢 Serveur dédié avec Laravel Forge

---

## 🐛 Débogage

### Mode Debug

Activez le debug mode dans `.env` :

```env
APP_DEBUG=true
```

### Logs

Les logs se trouvent dans `storage/logs/` :

```bash
# Voir les logs en temps réel
php artisan pail

# Plus old logs tools
tail -f storage/logs/laravel.log
```

### Outils

- Laravel Query Logger : `DB::listen` pour logger les requêtes SQL
- Ray : Outil de debugging graphique
- Telescope : Profiler Laravel

---

## 📊 SEO & Performance

### SEO Optimisations

- ✅ Meta tags et Open Graph
- ✅ Sitemap XML auto-généré
- ✅ Robots.txt
- ✅ Canonical URLs
- ✅ Schema.org microdata

```bash
# Générer la sitemap
php artisan sitemap:generate
```

### Performance

- ✅ Compilation Laravel assets
- ✅ Lazy loading des relations
- ✅ Database query optimization
- ✅ Caching strategies
- ✅ CDN pour les assets statiques

---

## 🤝 Contribution

Les contributions sont les bienvenues ! Voici comment contribuer :

### Process de Contribution

1. **Forker** le repository
2. **Créer une branche** pour votre feature : `git checkout -b feature/amazing-feature`
3. **Commiter** vos changements : `git commit -m 'Add amazing feature'`
4. **Pusher** la branche : `git push origin feature/amazing-feature`
5. **Ouvrir une Pull Request**

### Guidelines

- 📝 Respecter les conventions de code (PSR-12)
- ✅ Ajouter des tests pour les nouvelles features
- 🔍 S'assurer que tous les tests passent
- 📚 Mettre à jour la documentation
- 💬 Avoir des commits clairs et descriptifs

---

## 📞 Support & Contact

### Besoins d'Aide?

- 📧 **Email** : support@hrad-dschang.com
- 🐛 **Issues** : [GitHub Issues](../../issues)
- 📚 **Documentation** : Voir le dossier [docs/](docs/)
- 💬 **Discord/Chat** : À venir

---

## 📄 Licences & Crédits

### License

Ce projet est sous license **MIT License** - voir le fichier [LICENSE](LICENSE) pour les détails.

### Crédits

- **Framework** : [Laravel](https://laravel.com) par Taylor Otwell
- **Frontend** : [Vue.js](https://vuejs.org) par Evan You
- **Styling** : [Tailwind CSS](https://tailwindcss.com)
- **Adapter** : [Inertia.js](https://inertiajs.com) par Jonathan Reinink
- **Icons** : [Lucide](https://lucide.dev)

### Auteurs

- **Développement** : Équipe Développement HRAD
- **Design** : Équipe Design
- **Project Management** : HRAD Management

---

## 🎓 Ressources Additionnelles

### Documentations Externes

- [Laravel Documentation](https://laravel.com/docs)
- [Vue.js Guide](https://vuejs.org/guide/introduction.html)
- [Inertia.js Documentation](https://inertiajs.com)
- [Tailwind CSS Docs](https://tailwindcss.com/docs)

### Documentations Internes

- [📘 Guide Développeur](docs/DEVELOPER_GUIDE.md)
- [📋 Résumé du Projet](docs/PROJECT_SUMMARY.md)
- [⚡ Installation Rapide](docs/INSTALLATION_RAPIDE.md)
- [🔧 Guide Utilisateur](docs/GUIDE_UTILISATEUR.md)

---

## 📈 Roadmap

### Version 1.0 (Current) ✅
- ✅ Pages publiques (Home, Services, Médecins, À Propos)
- ✅ Système de rendez-vous
- ✅ Gestion admin
- ✅ Actualités et articles

### Version 1.1 (Upcoming) 🔄
- 🔄 Paiement en ligne (Stripe, PayPal)
- 🔄 Notification SMS
- 🔄 Calendrier intégré
- 🔄 Système de review/rating

### Version 2.0 (Future) 📅
- 📅 Application mobile (React Native)
- 📅 Intégration avec systèmes médicaux
- 📅 Dashboard analytiques avancé
- 📅 AI-powered chatbot

---

## ⭐ Montrer du Support

N'hésitez pas à donner une ⭐ étoile si vous trouvez ce projet utile !

---

<div align="center">

**Fait avec ❤️ pour l'Hôpital HRA Dschang**

[Homepage](https://hrad-dschang.cm) • [Issues](../../issues) • [Discussions](../../discussions) • [Wiki](../../wiki)

© 2025-2026 HRA Dschang. Tous droits réservés.

</div>
