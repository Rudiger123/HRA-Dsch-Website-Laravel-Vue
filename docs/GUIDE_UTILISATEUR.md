# 🔧 Guide Utilisateur Complet - HRA Dschang

**Date:** 17 février 2026  
**Public:** Administrateurs et staff  
**Langue:** Français

---

## 📑 Table des matières

1. [Introduction](#introduction)
2. [Se connecter](#se-connecter)
3. [Navigation dashboard](#navigation-dashboard)
4. [Gestion des services](#gestion-des-services)
5. [Gestion des médecins](#gestion-des-médecins)
6. [Gestion des tarifs](#gestion-des-tarifs)
7. [Gestion des horaires](#gestion-des-horaires)
8. [Gestion des actualités](#gestion-des-actualités)
9. [Gestion des rendez-vous](#gestion-des-rendez-vous)
10. [Gestion des messages](#gestion-des-messages)
11. [Mon profil](#mon-profil)
12. [FAQ](#faq)

---

## Introduction

Bienvenue sur le **portail administrateur HRA Dschang**! 

Cet interface vous permet de gérer:
- 🏥 Services médicaux
- 👨‍⚕️ Équipe médicale (médecins)
- 💰 Tarifs et services
- ⏰ Horaires d'ouverture
- 📰 Actualités et blog
- 📅 Demandes de rendez-vous
- 💬 Messages de contact
- 👤 Profil professionnel

### Accès
- **URL:** https://hra-dschang.cm/admin/login
- **Email:** admin@test.local
- **Mot de passe:** Celui défini lors de création compte

---

## Se connecter

### Première connexion

1. **Ouvrir** https://hra-dschang.cm/admin/login
2. **Saisir** votre email administrateur
3. **Saisir** votre mot de passe
4. **Cliquer** sur le bouton bleu "Se connecter"

### Si vous oubliez le mot de passe

1. Sur la page de connexion, cliquer "**Mot de passe oublié?**"
2. Saisir votre **email administrateur**
3. **Vérifier votre email** - un lien est envoyé
4. **Cliquer le lien** dans l'email
5. **Créer un nouveau mot de passe**
6. **Se connecter** avec le nouveau mot de passe

### Si vous n'accédez pas

**Vérifier:**
- ✅ Compte actif (admin peut désactiver)
- ✅ Email correct et sans typo
- ✅ Mot de passe correct
- ✅ Majuscules/minuscules importance!
- ✅ Effacer cache navigateur (Ctrl+Shift+Del)

**Contact:** admin@hra-dschang.cm ou Super Admin

---

## Navigation Dashboard

### Page d'accueil (Dashboard)

Après connexion, vous voyez le **tableau de bord** avec:

#### Statistiques principales

```
┌─────────────────────────────────────────┐
│  📊 STATISTIQUES HRA DSCHANG              │
├─────────────────────────────────────────┤
│  Services médicaux:  12                 │
│  Médecins:           18                 │
│  RDV en attente:     7                  │
│  Messages non lus:   3                  │
│  Articles publiés:   34                 │
└─────────────────────────────────────────┘
```

#### Graphique RDV

- Demandes par service (pie chart)
- Tendance sur 30 jours (line chart)
- Export possible

#### Actions rapides

Boutons d'accès rapide vers les pages principales.

### Menu latéral

**Navigation par catégorie:**

```
📊 DASHBOARD
───────────────
🏥 SERVICES
   ├─ Liste services
   └─ Créer service

👨‍⚕️ MÉDECINS
   ├─ Liste médecins
   └─ Ajouter médecin

💰 TARIFICATION
   ├─ Tarifs
   └─ Horaires

📅 RENDEZ-VOUS
   ├─ Demandes RDV
   ├─ Statistiques
   └─ Export

📰 ACTUALITÉS
   ├─ Liste articles
   ├─ Créer article
   └─ Catégories

💬 CONTACT
   ├─ Messages reçus
   └─ Non lus

👤 MON PROFIL
   ├─ Éditer profil
   └─ Sécurité

⚙️ ADMINISTRATION (Super Admin)
   └─ Gestion utilisateurs
```

---

## Gestion des services

### Vue d'ensemble services

**Menu:** Cliquer **SERVICES** → **Liste services**

Affiche tous les services avec:
- Nom du service
- Description (aperçu)
- Nombre horaires définis
- Status (Actif/Inactif)
- Actions (Éditer, Supprimer)

### Créer un nouveau service

1. **Menu:** Services → "+ Créer service" ou cliquer le bouton bleu **+ Nouveau**
2. **Remplir le formulaire:**

| Champ | Explication | Exemple |
|-------|-------------|---------|
| **Nom** | Nom du service | Pédiatrie |
| **Description** | Détails du service (ce qu'il offre) | Services de santé pour enfants... |
| **Icône** | Choisir icône qui représente | Baby 👶 |
| **Tarif consultation** | Prix consultation standard (FCFA) | 5000 |
| **Ordre affichage** | Position sur site (0=premier) | 1 |

3. **Cliquer** le bouton vert "Créer service"

### Modifier un service

1. **Dans la liste**, cliquer sur le **nom du service**
2. **Modifier les champs** souhaités
3. **Cliquer "Mettre à jour"** (bouton bleu)

### Activer/Désactiver service

**Méthode 1 - Liste:**
- Dans la liste, visible **toggle switch** à droite
- Basculer ON/OFF pour activer/désactiver

**Méthode 2 - Édition:**
- Ouvrir service
- Cocher/décocher "Service actif"
- Sauvegarder

**➡️ Services inactifs n'apparaissent pas aux patients**

### Supprimer un service

1. **Dans la liste**, cliquer le bouton rouge **🗑 Supprimer**
2. **Confirmer** que vous êtes sûr
3. **Service supprimé** (données associées aussi)

⚠️ **Attention:** Suppression définitive!

---

## Gestion des médecins

### Lister médecins

**Menu:** Médecins → Liste

Affiche table avec:
- Nom et spécialité
- Photo passport
- Services affiliés
- Status actif/inactif
- Actions

### Ajouter médecin

1. **Cliquer** "+ Ajouter médecin"
2. **Remplir le formulaire:**

| Champ | Type | Notes |
|-------|------|-------|
| **Nom complet** | Texte | Ex: "Dr. Jean Martin" |
| **Spécialité** | Texte | Ex: "Pédiatre, Cardiologue" |
| **Diplômes** | Texte long | Énumérez tous diplômes/certifications |
| **Biographie** | Texte long | Résumé professionnel médecin |
| **Langues** | Texte | Séparées virgules: Français, Anglais, Allemand |
| **Photo** | Upload image | JPG/PNG, min 300x400px |
| **Services** | Checkboxes | Cocher services où médecin travaille |

3. **Télécharger photo:**
   - Cliquer zone "Déposer fichier"
   - Sélectionner image depuis ordi
   - OU glisser-déposer image

4. **Cliquer "Créer médecin"**

### Éditer médecin

1. **Cliquer sur le nom** du médecin dans liste
2. **Modifier les champs**
3. **Changer la photo** (cliquer zone upload)
4. **Cliquer "Mettre à jour"**

### Supprimer photo médecin

1. **Ouvrir fiche médecin**
2. **Bouton rouge** "Supprimer photo"
3. **Confirmer**

Le médecin reste, juste sa photo est supprimée.

### Médecins inactifs

- Toggle "Médecin actif" OFF
- Médecin n'aparaît plus aux patients
- Conserve toutes les données

---

## Gestion des tarifs

### Accéder tarifs

**Menu:** Tarification → **Tarifs**

Affiche liste tarifs par service avec:
- Designation (nom du service/acte)
- Montant en FCFA
- Type patient (normal/étudiant/urgence)

### Ajouter tarif

1. **Cliquer** "+ Ajouter tarif"
2. **Form:**

| Champ | Exemple |
|-------|---------|
| **Service** | Pédiatrie (dropdown) |
| **Désignation** | Consultation générale enfant |
| **Montant** | 5000 (FCFA) |
| **Type patient** | Normal ⭕ |
| **Détails** | Ce qui est inclus: examen général, diagnostic... |

3. **Cliquer "Ajouter"**

### Modifier tarif

1. **Cliquer l'icône ✏️ éditer** à côté du tarif
2. **Modifier montant, détails, etc.**
3. **Cliquer "Mettre à jour"**

### Supprimer tarif

1. **Cliquer le bouton** 🗑 à droite du tarif
2. **Confirmer**

### Types de patients

- **Normal:** Tarif standard pour tous
- **Étudiant:** Réduction pour carte student
- **Urgence:** Urgences médicales

---

## Gestion des horaires

### Accéder horaires

**Menu:** Tarification → **Horaires**

Tableau horaires par service et jour.

### Ajouter horaire

1. **Cliquer** "+ Ajouter horaire"
2. **Remplir:**

| Champ | Exemple |
|-------|---------|
| **Service** | Pédiatrie |
| **Jour semaine** | Lundi, Mardi... |
| **Ouverture** | 08:00 |
| **Fermeture** | 17:00 |
| **Note** | (optionnel) Urgences: 24/24 |

3. **Cliquer "Ajouter"**

### Modifier horaire

1. **Icône ✏️** à côté de l'horaire
2. **Modifier heures**
3. **Sauvegarder**

### Supprimer horaire

1. **Bouton 🗑**
2. **Confirmer**

### Heures d'ouverture

- **Ouverture:** Heure d'ouverture (ex: 08:00)
- **Fermeture:** Heure fermeture (ex: 17:00)
- **Note:** Exceptions (ex: "Urgences ouvertes 24/24")

---

## Gestion des actualités

### Liste articles

**Menu:** Actualités → **Liste**

Affiche tous articles avec:
- Titre
- Catégorie
- Date publication
- Status (Publié/Brouillon)
- Vues et likes
- Actions

### Créer article

1. **Cliquer** "+ Créer article" (bouton bleu)
2. **Remplir le formulaire:**

#### Informations de base

| Champ | Type | Notes |
|-------|------|-------|
| **Titre** | Texte | Titre principal article |
| **Catégorie** | Dropdown | nutrition, prévention, événements |
| **Auteur** | Texte | Nom auteur (défaut: "Équipe HRA") |

#### Contenu

| Champ | Type | Notes |
|-------|------|-------|
| **Extrait** | Texte court (200 char) | Résumé qui aparaît en liste |
| **Contenu** | Éditeur riche | Texte complet avec formatting |

#### Médias

| Champ | Type | Notes |
|-------|------|-------|
| **Image** | Upload | Image couverture |
| **Vidéo YouTube** | URL | Lien YouTube complet |

#### Avant publication

| Champ | Effet |
|-------|--------|
| **Date publication** | Quand publier l'article |
| **Publié** | Cocher pour publier |

### Editeur riche (TipTap)

**Outils disponibles:**

```
[B] Gras        [I] Italique     [U] Underline
[1] Titre 1     [2] Titre 2      [3] Titre 3
[•] Bullet list [1.] Numbered    ["] Block quote
[<] Indent      [>] Unindent     [🔗] Lien
[📷] Image      [≡] Table
```

**Upload image:**
- Cliquer icône 📷
- Sélectionner image
- OU Drag & drop directement

### Publier/Dépublier

**Avant publication:**
1. Cocher "✓ Article publié"
2. Définir "Date publication"
3. Cliquer "Créer"

**Article sera visible sur site public**

### Éditer article

1. **Cliquer le titre** dans liste
2. **Modifier contenu**
3. **Cliquer "Mettre à jour"**

### Supprimer article

1. **Bouton rouge 🗑**
2. **Confirmer**

### Archiver article

Dépublier (toggle OFF) pour masquer sans supprimer.

---

## Gestion des rendez-vous

### Tableau RDV

**Menu:** Rendez-vous → **Demandes**

Affiche liste demandes avec:
- Nom patient
- Service
- Statut (En attente/Confirmé/Annulé)
- Date souhaitée
- Actions

### Filtres

**Filtrer par:**
- Service demandé
- Statut (dropdown)
- Date
- Patient (recherche)

### Voir détails RDV

1. **Cliquer le nom du patient**
2. **Voir toutes les infos:**
   - Nom, email, téléphone
   - Âge
   - Service demandé
   - Motif consultation
   - Date souhaitée
   - Status actuel

3. **Boutons rapides:**
   - "Confirmer RDV" (vert)
   - "Annuler RDV" (rouge)

### Changer statut RDV

**Trois status:**

```
🔵 EN ATTENTE (bleu)
   → Nouvelle demande, à traiter

🟢 CONFIRMÉ (vert)
   → Email envoyé au patient
   → Patient peut se préparer

🔴 ANNULÉ (rouge)
   → Email notification annulation
   → Patient alerté
```

**Pour changer:**

1. **Aller** dans détails RDV
2. **Cliquer bouton** du statut souhaité
3. **Confirmé?** Email envoyé automatiquement

### Statistiques RDV

**Menu:** Rendez-vous → **Statistiques**

Affiche:
- Graphique RDV par service
- Tendance 30 derniers jours
- Total confirmés/en attente/annulés
- Top services demandés

### Exporter RDV

**Menu:** Rendez-vous → **Export**

1. **Filtrer** les RDV souhaités
2. **Cliquer "Exporter CSV"**
3. **Fichier téléchargé** (ouvrir avec Excel)

---

## Gestion des messages

### Inbox messages

**Menu:** Contact → **Messages**

Liste messages reçus avec:
- Nom expéditeur
- Email expéditeur
- Aperçu message (premiers caractères)
- Status "lu / non-lu"

**Messages non lus = caractères gras**

### Lire message

1. **Cliquer le message**
2. **Voir contenu complet**
3. **Infos expéditeur:**
   - Nom
   - Email
   - Téléphone (si fourni)
   - Date envoi

### Répondre par email

1. **Dans le message**, cliquer **"Répondre"**
2. **Composer réponse** dans la zone
3. **Cliquer "Envoyer"**

Email réponse envoyé au patient.

### Marquer lu/non-lu

**Bouton toggleà côté du message:**
- Gris = non-lu
- Blanc = Lu

### Supprimer message

1. **Bouton rouge 🗑**
2. **Confirmer**

**Message archivé (pas vraiment supprimé)**

---

## Mon profil

### Éditer mes infos

**Menu:** Mon profil → **Éditer**

Modifier:
- ✏️ Nom complet
- 📧 Email (attention: sera nouveau login)
- ☎️ Téléphone
- 📷 Photo profil

**Cliquer "Mettre à jour"**

### Ma photo

**Upload photo:**
1. Zone "Déposer photo"
2. Cliquer ou drag-drop
3. Auto-recadré à 300x400px

**Supprimer photo:**
- Bouton rouge "Supprimer photo"

### Changer mot de passe

**Menu:** Mon profil → **Sécurité**

**Formulaire:**
- Ancien mot de passe (pour vérifier)
- Nouveau mot de passe
- Confirmer nouveau mot de passe

⚠️ **Après changement, vous devrez vous reconnecter!**

### Requirements mot de passe

✅ Minimum 8 caractères  
✅ Mélange MAJUSCULES et minuscules  
✅ Au moins 1 chiffre  
✅ Au moins 1 caractère spécial (!@#$%^&*)

---

## FAQ

### Problèmes courants

#### Q: Connexion refuse
**R:** Vérifier:
- Email exact (avec point et @)
- Majuscules/minuscules
- Compte actif (admin peut désactiver)
- Effacer cookies navigateur

#### Q: Impossible uploader image
**R:** Vérifier:
- Format JPG/PNG
- Taille < 5MB
- Résolution minimum 300x300px
- Espace disque disponible

#### Q: Email non reçu
**R:** 
- Vérifier **dossier SPAM**
- Attendre 5-10 minutes
- Vérifier email correct
- Contacter support IT

#### Q: Perdre données après déconnexion
**R:** Données sauvegardées automatiquement:
- Cliquer "Sauvegarder" ou "Créer"
- Pas auto-save (brouillons perdus)

#### Q: Caractères accentués mal affichés
**R:**
- Actualiser page (F5)
- Effacer cache (Ctrl+Shift+Del)
- Vérifier encodage UTF-8

#### Q: Impossible modifier un champ verrouillé
**R:** Peut être:
- Droits insuffisants (permission)
- Champ lié à autre donnée
- Contact super admin pour débloquer

#### Q: Affichage décalé/bug d'interface
**R:**
- Navigateur moderne recommandé (Chrome, Firefox, Edge)
- Effacer cache
- Zoom 100% (éviter zoom custom)
- Rapatrier extensions navigateur

#### Q: Performance lenteur
**R:**
- Connexion internet? (tester vitesse)
- Serveur surchargé? (essayer autre moment)
- Navigateur lent? (trop d'onglets)
- Contacter support IT

#### Q: Sauvegarder vers Excel
**R:**
- Export CSV disponible certaines pages
- Ouvrir CSV avec Microsoft Excel
- Importer dans feuille existante

#### Q: Revenir en arrière après suppression
**R:** ⚠️ Suppression généralement définitive
- Chercher dans **Activity Log** historique
- Demander à Admin une récup de backup
- À l'avenir, soft-delete données importantes

---

## Contacts et Support

### Support IT

**Pour problèmes techniques:**

📧 Email: admin@hra-dschang.cm  
📞 Téléphone: +237 XXXXXXXXX  
🕐 Heures: 8h-17h Lundi-Vendredi

### Super Admin

**Demandes accès/permissions:**

Contacter directeur IT HRA pour:
- Réinitialiser mot de passe oublié
- Gérer nouveaux utilisateurs
- Restaurer données supprimées

---

## Checklist utilisation

**Avant de quitter:**
- [ ] Données sauvegardées
- [ ] Se déconnecter (cliquer profil → Déconnexion)
- [ ] Fermer navigateur si PC partagé

**Quotidien:**
- [ ] Vérifier 📊 Dashboard
- [ ] Traiter 📅 RDV en attente
- [ ] Lire 💬 Messages nouveaux
- [ ] Mettre à jour 📰 actualités

**Mensuel:**
- [ ] Exporter 📑 RDV/statistiques
- [ ] Archiver messages anciens
- [ ] Vérifier tarifs à jour

---

**Besoin du support technique ou d'une formation?**

Contacter l'administrateur système HRA Dschang.

**Dernière mise à jour:** 17 février 2026
