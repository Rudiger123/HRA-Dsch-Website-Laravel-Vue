# 🛠️ Guide Maintenance et Dépannage Production

**Date:** 17 février 2026  
**Audience:** DevOps, Administrateurs système  
**Environnement:** Production

---

## 📑 Table des matières

1. [Monitoring et Health Checks](#monitoring-et-health-checks)
2. [Backups et Récupération](#backups-et-récupération)
3. [Problèmes courants](#problèmes-courants)
4. [Performance et Optimisation](#performance-et-optimisation)
5. [Sécurité](#sécurité)
6. [Mises à jour](#mises-à-jour)
7. [Logs et Audit](#logs-et-audit)
8. [Escalade Support](#escalade-support)

---

## Monitoring et Health Checks

### Health Check endpoint

```bash
# Vérifier santé application
curl https://hra-dschang.cm/health

# Réponse succès (200 OK)
{
  "status": "ok",
  "database": "connected",
  "uptime": 342000
}
```

### Logs applicatifs

**Location:** `storage/logs/laravel.log`

```bash
# Voir les erreurs temps réel
tail -f storage/logs/laravel.log

# Voir seulement les ERREURS
tail -f storage/logs/laravel.log | grep ERROR

# Voir dernier 100 lignes
tail -n 100 storage/logs/laravel.log

# Chercher pattern spécifique
grep "user_id" storage/logs/laravel.log | tail -20
```

**Niveaux de log:**
- `EMERGENCY` - Système down
- `ALERT` - Action immédiate requise
- `CRITICAL` - Condition critique
- `ERROR` - Erreur runtime
- `WARNING` - Avertissement
- `NOTICE` - Info notable
- `INFO` - Information générale
- `DEBUG` - Debug messages

### Monitoring CPU/Mémoire

```bash
# Utilisation ressources
top -b -n 1 | head -20

# Disque utilisé
df -h

# Mémoire disponible
free -h

# Processus PHP
ps aux | grep php

# Queue listener running?
ps aux | grep "queue:listen"
```

### Vérifier services critiques

```bash
# Database connection
php artisan tinker
>>> DB::connection()->getPdo()  # Doit retourner PDO object

# Cache
php artisan tinker
>>> cache()->put('test', 'value', 10)
>>> cache()->get('test')

# Queue
php artisan queue:work --once  # Run 1 job
```

### Alertes et notifications

**Configurer alertes:**

```bash
# Erreurs 5xx - Contacter admin
# Downtime > 5 min - Alert escalade
# Disk > 90% - Nettoyer logs
# Queue stuck - Redémarrer listener
```

---

## Backups et Récupération

### Stratégie de backup

**Recommandée:**
- ✅ Quotidienne (minuit UTC)
- ✅ Conserve 7 jours
- ✅ Stockage délocalisé (cloud)

### Backup database

```bash
# MySQL backup
mysqldump -u root -p hra_dschang > backup_$(date +%Y%m%d_%H%M%S).sql

# Compression
mysqldump -u root -p hra_dschang | gzip > backup_$(date +%Y%m%d).sql.gz

# Backup avec tous dossiers
mysqldump -u root -p --databases hra_dschang > full_$(date +%Y%m%d).sql

# Vérifier intégrité
mysql -u root -p < backup_20260217.sql  # Test restore

# Stockage cloud (AWS S3)
aws s3 cp backup_20260217.sql.gz s3://hra-backups/
```

### Backup fichiers

```bash
# Dossier storage (uploads)
tar -czf storage_backup_$(date +%Y%m%d).tar.gz storage/app/public/

# Dossier config
tar -czf config_backup_$(date +%Y%m%d).tar.gz config/ .env

# Dossier complet (sauf node_modules, vendor)
tar --exclude='node_modules' --exclude='vendor' \
    --exclude='storage/logs' --exclude='.git' \
    -czf full_backup_$(date +%Y%m%d).tar.gz .
```

### Script backup automatisé

**Fichier:** `/root/scripts/backup.sh`

```bash
#!/bin/bash

# Configuration
DB_USER="root"
DB_PASS="secure_password"
DB_NAME="hra_dschang"
BACKUP_DIR="/backups"
DATE=$(date +%Y%m%d_%H%M%S)
S3_BUCKET="s3://hra-backups"

# Créer répertoire
mkdir -p $BACKUP_DIR

# Backup database
echo "Backing up database..."
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_$DATE.sql.gz

# Backup files
echo "Backing up files..."
tar -czf $BACKUP_DIR/storage_$DATE.tar.gz \
    --exclude='node_modules' \
    --exclude='vendor' \
    /var/www/hrad-site/storage/app/public/

# Upload to S3
echo "Uploading to S3..."
aws s3 cp $BACKUP_DIR/db_$DATE.sql.gz $S3_BUCKET/
aws s3 cp $BACKUP_DIR/storage_$DATE.tar.gz $S3_BUCKET/

# Cleanup local backups > 7 jours
find $BACKUP_DIR -name "db_*.sql.gz" -mtime +7 -delete
find $BACKUP_DIR -name "storage_*.tar.gz" -mtime +7 -delete

echo "Backup completed successfully!"
```

**Ajouter à cron:**

```bash
# Backup chaque jour à 2h du matin
0 2 * * * /root/scripts/backup.sh >> /var/log/backup.log 2>&1
```

### Restaurer depuis backup

```bash
# Restore database
mysql -u root -p hra_dschang < backup_20260217.sql

# Restore depuis gzip
gunzip < backup_20260217.sql.gz | mysql -u root -p hra_dschang

# Restore files
tar -xzf storage_backup_20260217.tar.gz -C /var/www/hrad-site/

# Vérifier intégrité après restore
php artisan migrate:status
php artisan tinker
>>> User::count()
```

---

## Problèmes courants

### Symptoms: Site répond pas (500 Error)

**Diagnostic:**

```bash
# 1. Vérifier logs
tail -50 storage/logs/laravel.log | grep ERROR

# 2. Vérifier database
php artisan tinker
>>> DB::connection()->getPdo()

# 3. Vérifier permissions fichiers
ls -la storage/
# Doit être: drwxrwxrwx www-data:www-data

# 4. Vérifier disque
df -h /var/www/
```

**Fix:**

```bash
# Permissions
chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage

# Re-cache config
php artisan config:clear
php artisan config:cache

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

# Restart queue
sudo systemctl restart laravel-queue
```

### Symptoms: Database connection error

```bash
# Vérifier MySQL running
sudo systemctl status mysql

# Vérifier credentials .env
cat .env | grep DB_

# Tester connection
mysql -h $DB_HOST -u $DB_USER -p$DB_PASS -e "SELECT 1"

# Voir processus connections
mysql -u root -p -e "SHOW PROCESSLIST;" | grep hra

# Vérifier socket file
ls -la /var/run/mysqld/mysqld.sock
```

**Fix:**

```bash
# Redémarrer MySQL
sudo systemctl restart mysql

# Augmenter max connections si nécessaire
sudo mysql -u root -p -e "SET GLOBAL max_connections = 500;"
```

### Symptoms: Emails n'arrivent pas

```bash
# Vérifier logs de queue
tail -f storage/logs/laravel.log | grep Mail

# Vérifier queue jobs pending
php artisan queue:failed  # Voir jobs failed

# Retry failed jobs
php artisan queue:retry all

# Test email manuellement
php artisan tinker
>>> Mail::to('test@example.com')->send(new TestMail())
```

**Fix:**

```bash
# Vérifier SMTP credentials .env
cat .env | grep MAIL_

# Test SMTP connection
telnet smtp.gmail.com 587

# Redémarrer queue listener
pkill -f "queue:listen"
php artisan queue:listen &

# Vérifier authentification Gmail
# App-specific password, pas username/password
```

### Symptoms: Upload fichiers fails

```bash
# Vérifier storage link
ls -la public/storage

# Vérifier permissions
ls -la storage/app/public/

# Disk space disponible?
df -h /var/www/
```

**Fix:**

```bash
# Recréer symlink
php artisan storage:link

# Permissions
chmod -R 775 storage/app/public/
sudo chown -R www-data:www-data storage/app/public/

# Si disk full
# Archiver anciens fichiers:
tar -czf old_files_backup.tar.gz storage/app/public/old_*
rm -rf storage/app/public/old_*
```

### Symptoms: Queue stuck (RDV/Emails pas envoyés)

```bash
# Vérifier queue jobs
php artisan queue:failed

# Voir stats job
php artisan queue:work --once  # Run 1 job

# Vérifier processus
ps aux | grep queue

# Nombre de jobs en queue
php artisan tinker
>>> DB::table('jobs')->count()
```

**Fix:**

```bash
# Kill stuck queue listener
pkill -f "queue:listen"

# Retrier failed jobs
php artisan queue:retry all

# Restart queue
nohup php artisan queue:listen --tries=3 &

# Superviser avec systemd
sudo systemctl restart laravel-queue
```

---

## Performance et Optimisation

### Slow query logging

**MySQL configuration:**

```sql
-- Activer slow query log
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2;  -- Queries > 2s

-- Voir logs
TAIL -f /var/log/mysql/slow.log

-- Analyser avec mysqldumpslow
mysqldumpslow -s c -t 10 /var/log/mysql/slow.log  -- Top 10 queries
```

### Database optimization

```bash
# Analyser tables
php artisan tinker
>>> DB::table('users')->explain()

# Ajouter indexes manquants
# Dans migration:
$table->index('email');
$table->index(['status', 'created_at']);

# Défragmention tables
php artisan tinker
>>> DB::statement("OPTIMIZE TABLE users, services, medecins");
```

### Redis caching

```bash
# Installation
sudo apt-get install redis-server

# Vérifier fonctionnel
redis-cli ping

# Configuration Laravel
# .env:
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
```

### Query caching

```php
// Cache queries lourdement utilisées
$services = cache()->remember('services.active', 3600, function() {
    return Service::actif()->with('medecins', 'horaires')->get();
});

// Invalider au changement
cache()->forget('services.active');
```

### Asset optimization

```bash
# Minification CSS/JS
npm run build

# Gzip compression (Nginx)
# /etc/nginx/nginx.conf
gzip on;
gzip_types text/plain text/css text/javascript;
gzip_min_length 256;
```

---

## Sécurité

### HTTPS / SSL

**Vérifier certificat valide:**

```bash
# Check SSL certificate
openssl s_client -connect hra-dschang.cm:443

# Vérifier date expiration
echo | openssl s_client -servername hra-dschang.cm -connect hra-dschang.cm:443 2>/dev/null | openssl x509 -noout -dates

# Renouveler Let's Encrypt avant expiration
sudo certbot renew

# Force HTTPS
# Nginx config
server {
    listen 80;
    server_name hra-dschang.cm,www.hra-dschang.cm;
    return 301 https://$server_name$request_uri;
}
```

### Firewall

```bash
# UFW (Uncomplicated Firewall)
sudo ufw enable
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow 22/tcp   # SSH
sudo ufw allow 80/tcp   # HTTP
sudo ufw allow 443/tcp  # HTTPS
sudo ufw status
```

### File permissions

```bash
# Fichiers doivent être lisibles par web server
sudo chown -R www-data:www-data /var/www/hrad-site

# Exact permissions
find /var/www/hrad-site -type f -exec chmod 644 {} \;  # Fichiers
find /var/www/hrad-site -type d -exec chmod 755 {} \;  # Dossiers

# Storage accessible write
chmod -R 775 storage bootstrap/cache

# .env unreadable par public
chmod 600 .env
```

### Credentials management

```bash
# JAMAIS commiter .env
# .gitignore:
.env
.env.local
.env.*.local

# Utiliser variables d'environnement
# Ou secrets tools (HashiCorp Vault)

# Audit accès credentials
grep "APP_KEY\|DB_PASSWORD\|MAIL_PASSWORD" .env  # ❌ Never in logs!
```

### SQL Injection prevention

**Laravel ORM safe:**

```php
// ✅ Safe - parameterized queries
User::where('email', $request->email)->first();

// ✅ Safe - bindings
DB::select('SELECT * FROM users WHERE email = ?', [$email]);

// ❌ DANGER - raw concatenation
DB::select("SELECT * FROM users WHERE email = '$email'");  // NEVER!
```

### XSS Prevention

```php
// ✅ Safe - escaped blade
{{ $user->name }}

// ✅ Safe - JSON encode
@json($data)

// ❌ DANGER - unescaped
{!! $user->bio !!}  // Only if you trust content
```

---

## Mises à jour

### Update Laravel framework

```bash
# Vérifier version
php artisan --version

# Check Laravel Shift (automated upgrades)
# https://laravelshift.com/

# Manual upgrade
composer update laravel/framework

# Run updated migrations
php artisan migrate

# Test après update
php artisan test
```

### Update dependencies

```bash
# Check outdated packages
composer outdated

# Safety: backup d'abord
git commit -am "Pre-update backup"

# Update carefully
composer update --dry-run  # Test
composer update

# Frontend dependencies
npm outdated
npm update
```

### Zero-downtime deployment

```bash
# 1. Préparer nouvelle version
git clone --branch <new-version> <repo>
cd new-version
composer install --no-dev
npm ci && npm run build

# 2. Symlink swap (instant)
ln -s /var/www/hrad-site-v2 /var/www/hrad-site-current

# 3. Run migrations (after swap)
php artisan migrate --force

# 4. Cache warm
php artisan cache:clear
php artisan config:cache
php artisan route:cache

# 5. Rollback if needed (revert symlink)
ln -s /var/www/hrad-site-v1 /var/www/hrad-site-current
```

---

## Logs et Audit

### Application logs

```bash
# Logs location
/var/www/hrad-site/storage/logs/laravel.log

# Rotation (Laravel auto-rotate)
# config/logging.php
'daily' => [
    'max' => 14,  // Keep 14 days
]

# View logs
tail -f storage/logs/laravel.log

# Grep errors
grep ERROR storage/logs/laravel.log | wc -l
```

### Activity Log (audit trail)

```php
// See who changed what
php artisan tinker
>>> Activity::all()

// Filter by model
>>> Activity::where('subject_type', 'App\Models\Service')->get()

// By user
>>> Activity::where('causer_id', 1)->get()
```

### Web server logs

```bash
# Nginx access log
tail -f /var/log/nginx/access.log

# Nginx error log
tail -f /var/log/nginx/error.log

# Apache logs
tail -f /var/log/apache2/access.log
tail -f /var/log/apache2/error.log

# Voir 404 errors
grep " 404 " /var/log/nginx/access.log | wc -l

# Suspicious patterns (SQL injection attempts)
grep -i "union.*select\|script\|javascript" /var/log/nginx/access.log
```

---

## Escalade Support

### Support Levels

**Level 1 - Utilisateurs:**
- Problèmes basiques utilisation
- Reset mot de passe
- Contact: admin@hra-dschang.cm

**Level 2 - DevOps/Admins:**
- Infrastructure issues
- Performance tuning
- Database problems
- Contact: tech-support@hra-dschang.cm

**Level 3 - Development:**
- Code bugs
- Feature requests
- Architecture changes
- Contact: dev-team@...

### Emergency Contacts

```
⚠️ URGENCE (Site down, data loss):
    📞 +237 6XX XXX XXX (24/7)
    📧 emergency@hra-dschang.cm
    
💬 NORMALES (Normal hours):
    📧 admin@hra-dschang.cm
    🕐 8h-17h Lun-Ven
```

### Incident Response

**En cas de panne:**

1. **Alert** - Vérifier health status
2. **Triage** - Identifier causa probable
3. **Notify** - Alert stakeholders
4. **Fix** - Apply solution or rollback
5. **Monitor** - Vérifier stabilité
6. **Postmortem** - Analyser leçons

**Runbook template:**

```
Symptôme: [Description problème]
Diagnostic: [Steps to reproduce]
Solution: [Fix]
Verification: [Confirm working]
Prevention: [Future prevention]
Time to fix: [Duration]
Root cause: [Analysis]
```

---

## Maintenance Schedule

### Quotidienne
- ✅ Vérifier logs pour erreurs
- ✅ Vérifier health endpoint
- ✅ Backup database
- ✅ Monitor disk space

### Hebdomadaire
- ✅ Review slow queries
- ✅ Check security updates
- ✅ Clean old logs
- ✅ Review backups

### Mensuelle
- ✅ Update dependencies
- ✅ Performance review
- ✅ Security audit
- ✅ Data integrity check

### Annuellement
- ✅ Major version upgrade
- ✅ SSL certificate renewal
- ✅ Disaster recovery drill
- ✅ Security penetration test

---

**Dernière mise à jour:** 17 février 2026

**Contacts support:**
- Tech Support: tech-support@hra-dschang.cm
- DevOps: devops@hra-dschang.cm
- Emergency: emergency@hra-dschang.cm
