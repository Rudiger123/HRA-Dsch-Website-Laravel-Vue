# Fonctionnalités de Réinitialisation de Mot de Passe et Pages d'Erreurs

## 📋 Vue d'ensemble

Ce document décrit les nouvelles fonctionnalités ajoutées:
1. **Réinitialisation de mot de passe (Reset Password)**
2. **Pages d'erreurs personnalisées**

---

## 🔐 Réinitialisation de Mot de Passe

### Architecture

La fonctionnalité de reset password utilise une architecture complète avec:

- **Contrôleurs d'authentification**:
  - `App\Http\Controllers\Auth\ForgotPasswordController` - Gère la demande de réinitialisation
  - `App\Http\Controllers\Auth\ResetPasswordController` - Gère la réinitialisation effecive

- **Pages Vue Inertia**:
  - `resources/js/Pages/Auth/ForgotPassword.vue` - Formulaire de demande
  - `resources/js/Pages/Auth/ResetPassword.vue` - Formulaire de réinitialisation

- **Mail personnalisé**:
  - `App\Mail\PasswordResetMail` - Classe de mail
  - `resources/views/emails/auth/reset-password.blade.php` - Vue du mail

### Flux d'utilisation

1. **Demande de réinitialisation**
   ```
   User → clicks "Mot de passe oublié?" on login page
        → Redirected to /admin/forgot-password
        → Enters email address
        → Receives reset link email
   ```

2. **Réinitialisation**
   ```
   User → Clicks link in email
        → Redirected to /admin/reset-password/{token}?email=user@example.com
        → Enters new password (min 8 characters)
        → Password is reset
        → Redirected to login page
   ```

### Routes

```php
// Routes publiques (guest only)
GET  /admin/forgot-password           → ForgotPasswordController@showLinkRequestForm
POST /admin/forgot-password           → ForgotPasswordController@sendResetLinkEmail
GET  /admin/reset-password/{token}    → ResetPasswordController@showResetForm
POST /admin/reset-password            → ResetPasswordController@reset
```

### Configuration importantes

**Durée de validité du token** (config/auth.php):
```php
'expire' => 60, // 60 minutes
'throttle' => 60, // Can request every 60 seconds
```

### Mail d'exemple

Le mail envoyé à l'utilisateur contient:
- ✅ Lien de réinitialisation unique
- ⏰ Durée de validité (60 minutes)
- 🔒 Avertissements de sécurité
- 📱 Design responsive
- 🎨 Branding HRA Dschang

### Variables d'environnement nécessaires

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io (ou votre SMTP)
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@hradschang.com
MAIL_FROM_NAME="HRA Dschang"
```

---

## ⚠️ Pages d'Erreurs Personnalisées

### Pages créées

Toutes les pages d'erreurs sont dans `resources/views/errors/`:

| Code | Fichier | Description |
|------|---------|-------------|
| 400 | `400.blade.php` | Requête invalide |
| 403 | `403.blade.php` | Accès refusé / Permission denied |
| 404 | `404.blade.php` | Page non trouvée |
| 419 | `419.blade.php` | Session expirée (CSRF) |
| 429 | `429.blade.php` | Trop de requêtes (Rate limit) |
| 500 | `500.blade.php` | Erreur serveur interne |
| 503 | `503.blade.php` | Service indisponible (Maintenance) |

### Layout partagé

Toutes les pages d'erreurs utilisent `resources/views/errors/layout.blade.php` qui fournit:
- Design cohérent
- Logo et branding HRA Dschang
- Boutons d'action (Accueil, Connexion, Tableau de bord)
- Contact du support

### Pages d'erreur personnalisées

Les pages d'erreur peuvent afficher:
- Code d'erreur distinctif
- Message d'erreur
- Description et contexte
- Suggestions d'action
- Boutons de navigation

### Utilisation

Les pages d'erreurs sont affichées **automatiquement** par Laravel quand:
- Une route n'existe pas → 404
- L'utilisateur n'a pas accès → 403
- Le token CSRF expire → 419
- Rate limit dépassée → 429
- Erreur serveur non gérée → 500
- Mode maintenance activé → 503

### Activation de la maintenance

```bash
php artisan down
php artisan up
```

---

## 🧪 Test

### Tester le reset password en local

1. Configurer Mailtrap ou mailhog
2. Accéder à `/admin/login`
3. Cliquer "Mot de passe oublié?"
4. Entrer un email existant
5. Vérifier les emails (Mailtrap/mailhog)
6. Cliquer le lien de réinitialisation
7. Entrer nouveau mot de passe (min 8 caractères)
8. Valider et se connecter

### Tester les pages d'erreurs

```bash
# Test 404
curl http://localhost:8000/admin/nonexistent

# Test 500 (déclencher une erreur)
# Modifier temporairement un contrôleur pour throw un exception

# Test 429 (Rate limit)
# Faire plusieurs requêtes rapidement à la même route

# Test 503
php artisan down
```

---

## 📝 Sécurité

### Mesures de sécurité implémentées

✅ Tokens de réinitialisation à usage unique
✅ Expiration automatique après 60 minutes
✅ Throttling (max 1 requête/minute)
✅ Validation d'email stricte
✅ Hashage de mot de passe sécurisé
✅ Logging d'activité
✅ CSRF protection sur les formulaires
✅ Validation côté serveur

### Bonnes pratiques

1. **Stocks tokenisés** : Les tokens sont stockés en base et not en cache par défaut
2. **Email valide** : Seuls les emails existants peuvent demander une réinitialisation
3. **Messages ambigus** : Les messages de réinitialisation ne révèlent pas si un email existe
4. **Avertissements** : L'email contient des avertissements de sécurité
5. **Logs d'activité** : Chaque réinitialisation est loggée

---

## 🎨 Personnalisation

### Modifier le delai d'expiration

```php
// config/auth.php
'passwords' => [
    'users' => [
        'expire' => 120, // 120 minutes instead of 60
    ],
],
```

### Modifier la validation du mot de passe

```php
// app/Http/Controllers/Auth/ResetPasswordController.php
'password' => ['required', 'confirmed', PasswordRule::min(12)] // 12 chars instead of 8
```

### Modifier le design des pages d'erreurs

Editez `resources/views/errors/layout.blade.php` et les fichiers `.blade.php` individuels.

---

## 📧 Customisation du mail

Pour modifier l'apparence du mail:

1. Editez `resources/views/emails/auth/reset-password.blade.php`
2. Modifiez `app/Mail/PasswordResetMail.php` pour changer les paramètres

---

## ✅ Checklist d'implémentation

- [x] Pages d'erreur 404, 500, 403, 419, 429, 503, 400
- [x] Pages Inertia pour ForgotPassword et ResetPassword
- [x] Contrôleurs d'authentification mis à jour
- [x] Mail personnalisé pour réinitialisation
- [x] Vue du mail HTML responsive
- [x] Logging d'activité
- [x] Validation complète
- [x] Lien "Mot de passe oublié?" dans la page de login
- [x] Documentation

---

## 🔗 Ressources

- [Laravel Password Reset](https://laravel.com/docs/11.x/passwords)
- [Inertia.js](https://inertiajs.com/)
- [Blade Templates](https://laravel.com/docs/11.x/blade)

