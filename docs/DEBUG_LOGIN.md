# 🔐 Debugging Connexion Admin

## Checklist de Debug

### 1. Vérifier la page de login

Accédez à : `http://localhost:8000/admin/login`

Et vérifiez dans la console du navigateur (F12) :
- Ouvrir l'onglet **Console**
- Ouvrir l'onglet **Network**
- Essayer de vous connecter
- Chercher la requête POST `/admin/login`

### 2. Informations pour la connexion

```
Email: admin@hradschang.cm
Password: password123
```

### 3. Vérifications lors de la connexion

1. **Regardez l'onglet Network** :
   - La requête POST `/admin/login` doit être envoyée
   - La réponse doit être un statut 200 ou 302 (redirection)

2. **Regardez la Console** :
   - Copiez toute erreur JavaScript
   - Vérifiez qu'il n'y a pas d'erreur CORS

3. **Regardez la page** :
   - Un message d'erreur apareça-t-il ?
   - La page se charge-t-elle après soumission ?

### 4. Si le formulaire ne s'envoie pas :

Ouvrez la console et exécutez :
```javascript
// Vérifier que Inertia.js est chargé
console.log(window.$inertia)

// Vérifier que le formulaire a les bonnes données
// (regardez dans les données du formulaire)
```

### 5. Si une erreur 422 ou 419 apparait :

Ceux sont des erreurs CSRF. Execute ceci dans la console :
```javascript
// Vérifier que le token CSRF est présent
document.querySelector('meta[name="csrf-token"]')
```

### 6. Points de vérification supplémentaires :

- [ ] La page `/admin/login` charge-t-elle correctement ?
- [ ] Peut-on taper dans les champs ?
- [ ] Le bouton "Se connecter" peut-on le cliquer ?
- [ ] Des changements dans l'onglet Network ?
- [ ] Des erreurs JavaScript ?

---

## Commandes utiles pour les logs

```bash
# Voir les logs Laravel (en développement)
tail -f storage/logs/laravel.log

# Si la base de données a des problèmes
php artisan tinker
# Puis dans tinker:
User::where('email', 'admin@hradschang.cm')->first()
# Devrait retourner l'utilisateur créé
```

## Erreurs courantes et solutions

### Error: Route not found
- La route POST `/admin/login` ne l'existe peut-être pas
- Vérifier `routes/web.php` ligne ~27

### Error: CSRF token mismatch
- Vérifier que le middleware CSRF n'est pas désactivé
- Vérifier que `<meta name="csrf-token">` est dans le layout

### Error: The given data was invalid
- Vérifier les identifiants (email/password)
- Vérifier que l'utilisateur `admin@hradschang.cm` existe :
  ```bash
  php artisan tinker
  User::all()
  ```

### Rien ne se passe (la page ne répond pas)
- Le serveur Laravel ne tourne pas ?
  ```bash
  php artisan serve
  ```
- Vérifier les logs : `tail -f storage/logs/laravel.log`
- Vérifier que vous êtes sur `localhost:8000` et pas sur `127.0.0.1:8000`

### Le formulaire s'envoie mais rien ne se passe

C'est probablement un problème dans le contrôleur Login. Vérifiez :

1. Que `LoginController::login()` existe
2. Que `LoginController::login()` valide les données
3. Que `LoginController::login()` appelle `Auth::attempt()`
4. Que la redirection vers `admin.dashboard` fonctionne
