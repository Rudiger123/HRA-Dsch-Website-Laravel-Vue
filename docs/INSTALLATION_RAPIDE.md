# 🚀 Guide d'Installation Rapide

**Date:** 17 février 2026  
**Environnement:** Linux/Mac/Windows (WSL)

---

## ⚡ Installation en 5 minutes (Développement)

### Étape 1 : Prérequis

Vérifier les versions:

```bash
php --version        # PHP 8.2+
node --version       # Node 18+
composer --version   # 2.x
```

### Étape 2 : Cloner et installer

```bash
# Cloner le projet
git clone <repo-url>
cd hrad-site

# Installation automatique complète
composer run-script setup

# Cela effectue:
# - composer install
# - Copie .env.example → .env
# - Génère APP_KEY
# - php artisan migrate
# - npm install
# - npm run build
```

### Étape 3 : Vérifier la base de données

```bash
# Vérifier que la BD a été migrée
php artisan migrate:status

# Créer données de test
php artisan db:seed
```

### Étape 4 : Démarrer le serveur

**Option A - Commande simplifiée:**

```bash
composer run dev
```

Cela démarre:
- ✅ Laravel Artisan (port 8000)
- ✅ Queue listener
- ✅ Vite dev server (port 5173)
- ✅ Logs en temps réel

**Option B - Séparé (pour debug):**

Terminal 1:
```bash
php artisan serve
```

Terminal 2:
```bash
npm run dev
```

### Étape 5 : Accéder l'application

```
Frontend:     http://localhost:8000
Admin panel:  http://localhost:8000/admin/login
API:          http://localhost:8000/api/...
Vite:         http://localhost:5173
```

### Credentials de test (après seeder)

```
Email:    admin@test.local
Password: password
```

---

## 🐳 Installation avec Docker (Sail)

```bash
# Démarrer Sail
./vendor/bin/sail up -d

# Ou sans build antérieur
./vendor/bin/sail up

# Accéder au shell
./vendor/bin/sail bash

# Migrations dans Docker
./vendor/bin/sail artisan migrate
```

---

## 🖥️ Installation Production

### 1. Hosting requirements

- PHP 8.2+ avec extensions (BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML)
- MySQL 5.7+ ou PostgreSQL
- Node.js 18+ pour build (ou pré-builder localement)
- HTTPS SSL
- Cron job pour queue

### 2. Deployment steps

```bash
# 1. Cloner depuis GitHub
git clone <repo-url>
cd hrad-site

# 2. Installation dépendances
composer install --no-dev --optimize-autoloader
npm ci
npm run build

# 3. Configuration
cp .env.example .env
nano .env  # Configurer variables

# 4. Génération clé
php artisan key:generate

# 5. Migrations
php artisan migrate --force

# 6. Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Permissions
chmod -R 755 storage bootstrap/cache
sudo chown -R www-data:www-data storage

# 8. Link storage
php artisan storage:link

# 9. Cron job pour queue (ajouter à crontab)
* * * * * cd /path/to/hrad-site && php artisan schedule:run >> /dev/null 2>&1
```

### 3. Variables .env production

```env
APP_NAME="HRA Dschang"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://hra-dschang.cm

DB_CONNECTION=mysql
DB_HOST=db.host.com
DB_PORT=3306
DB_DATABASE=hra_dschang
DB_USERNAME=db_user
DB_PASSWORD=strong_password_here

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=admin@hra-dschang.cm
MAIL_FROM_NAME="HRA Dschang"

# Optional
REDIS_HOST=redis.host.com
REDIS_PORT=6379
```

### 4. Web server configuration

**Nginx:**

```nginx
server {
    listen 80;
    server_name hra-dschang.cm www.hra-dschang.cm;
    root /var/www/hrad-site/public;
    
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    
    index index.php;
    
    charset utf-8;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    
    error_page 404 /index.php;
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

**Apache (.htaccess):**

Déjà inclus dans `public/.htaccess`

### 5. HTTPS SSL

```bash
# Certbot (Let's Encrypt)
sudo certbot certonly --webroot -w /var/www/hrad-site/public -d hra-dschang.cm

# Renouvellement automatique
sudo certbot renew --quiet
```

---

## ✅ Vérification installation

```bash
# Vérifier santé application
php artisan config:clear
php artisan config:show APP_NAME

# Vérifier database
php artisan migrate:status

# Vérifier permissions
ls -la storage/

# Vérifier mail
php artisan tinker
>>> Mail::raw('test', function($m) { $m->to('test@example.com'); });

# Vérifier routes
php artisan route:list

# Vérifier permissions users
php artisan tinker
>>> User::first()->roles;
```

---

## 🔧 Troubleshooting d'installation

### Erreur: "Could not open input file: artisan"

**Solution:** Vérifier répertoire courant

```bash
pwd
ls -la artisan
cd /path/to/hrad-site
```

### Erreur: "No such file or directory" (migration)

**Solution:** SQLite pas créé

```bash
touch database/database.sqlite
chmod 666 database/database.sqlite
php artisan migrate
```

### Erreur: "Composer dependencies not installed"

```bash
composer install
php artisan config:clear
```

### Erreur: "npm not found"

```bash
# Installer Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

### Erreur: Port déjà utilisé

```bash
# Utiliser port différent
php artisan serve --port=8001

# Tuer processus existant
lsof -i :8000
kill -9 <PID>
```

### Erreur: "The stream or file could not be opened"

**Cause:** Permissions logs insuffisantes

```bash
chmod 777 storage/logs
```

---

## 🧪 Vérification après installation

### Checklist

- [ ] Serveur démarre sans erreurs
- [ ] Base de données connectée
- [ ] Admin panel accessible (/admin/login)
- [ ] Authentification fonctionne
- [ ] Pages publiques chargent
- [ ] API endpoints répondent
- [ ] Upload fichiers fonctionne
- [ ] Emails envoient (vérifier logs)
- [ ] Queue listener tourne
- [ ] Assets CSS/JS chargent

### Test rapide

```bash
# Test authentification
php artisan tinker
>>> User::where('email', 'admin@test.local')->first()
>>> Hash::check('password', User::first()->password)

# Test relations
>>> User::first()->roles
>>> Service::first()->medecins

# Test mail
>>> Mail::to('admin@test.local')->send(new PasswordResetMail('token', 'admin@test.local'))
```

---

## 📚 Next steps

Après installation réussie:

1. [Lire guide utilisateur admin](./GUIDE_ADMIN.md)
2. [Consulter documentation API](./API_DOCUMENTATION.md)
3. [Guide développeur](./DEVELOPER_GUIDE.md)
4. [Consulter documentation complète](./DOCUMENTATION_COMPLETE.md)

---

**Besoin d'aide?**

- Email: admin@hra-dschang.cm
- Consulting: Contact développeur
