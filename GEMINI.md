# 🧠 FICHIER CONTEXTE QWEN – PROJET SHEERPA

---

# 🎯 VUE GÉNÉRALE DU PROJET

Sheerpa est une plateforme web développée avec Laravel qui met en relation :

- Des professionnels expérimentés (Guides)
- Des particuliers souhaitant découvrir, explorer ou se reconvertir vers un nouveau métier

Objectif principal :
→ Donner vie aux ambitions professionnelles grâce à des meetings en ligne, des masterclass et des échanges concrets avec des experts métiers.

---

# ⚠️ RÈGLE ABSOLUE DE COMMUNICATION

Tu dois TOUJOURS répondre en français.

Toutes les explications doivent être en français.

---

# 🏗 CONTEXTE TECHNIQUE

## Stack utilisée

- Backend : Laravel (MVC strict)
- Frontend : Blade / HTML / CSS / JS
- Base de données : MySQL
- Authentification : Laravel Auth
- Paiement : Stripe (ou équivalent)
- Environnement local : PHP Artisan
- Version Laravel : 10+

---

# 📦 MODULES PRINCIPAUX

## 1️⃣ Utilisateurs

- Inscription / Connexion
- Gestion du profil
- Gestion abonnement
- Historique des meetings
- Gestion du rôle (User / Guide / Admin)

---

## 2️⃣ Meetings

Champs principaux :

- title
- description
- category_id
- duration
- level
- guide_id
- start_date_time
- status (upcoming / past)
- enable_recording
- require_moderator_approval

Fonctionnalités :

- Liste des meetings
- Filtrage par catégorie
- Inscription
- Gestion des meetings à venir et passés

---

## 3️⃣ Masterclass

- Gratuite ou payante
- Lien vers catégorie
- Vidéo ou session live
- Accès contrôlé selon abonnement

---

## 4️⃣ Abonnements

Plans :

- Gratuit
- Guide Sheerpa (Premium)

Règles :

- Stripe Checkout
- Validation via Webhook obligatoire
- Mise à jour du statut uniquement après confirmation Stripe
- Middleware pour restreindre l’accès

---

## 5️⃣ Catégories

- name
- slug
- relation avec meetings
- relation avec masterclass

---

# 🗄 RÈGLES BASE DE DONNÉES

- Utiliser des clés étrangères
- Utiliser des index pour les filtres
- Stocker les dates en UTC
- Utiliser softDeletes si nécessaire
- Ne jamais dupliquer des données relationnelles
- Respecter snake_case pour la DB
- Respecter camelCase pour PHP

---

# 🔐 CONTRÔLE D’ACCÈS

- Auth obligatoire pour inscription aux meetings
- Premium obligatoire pour contenu premium
- Admin gère catégories et meetings globaux
- Guide gère uniquement ses meetings
- Utiliser des middleware Laravel

---

# 🎨 RÈGLES FRONTEND

- Blade propre (pas de logique métier)
- Validation Laravel obligatoire
- Messages d’erreur propres
- Composants réutilisables si possible
- Responsive design

---

# 🧠 RÈGLES DE GÉNÉRATION DE CODE

Quand tu génères du code :

1. Code prêt pour production.
2. Respect strict des conventions Laravel.
3. Toujours inclure validation.
4. Inclure migration si modification DB.
5. Inclure routes.
6. Séparer logique complexe dans un Service.
7. Sécurité obligatoire (CSRF, auth, validation).
8. Pas de pseudo-code.
9. Pas de sur-ingénierie.
10. Ne jamais casser l’existant.

---

# 🚀 ÉVOLUTIONS PRÉVUES

- Intégration Zoom ou Jitsi
- Système calendrier
- Notifications email
- Rappels automatiques
- Dashboard admin avancé
- Statistiques et analytics

---

# ❌ INTERDICTIONS

Ne jamais :

- Mettre de logique métier dans Blade
- Exposer des clés API
- Ignorer la validation
- Faire confiance aux données frontend
- Modifier d’anciennes migrations en production

---

# 📌 PHILOSOPHIE DU PROJET

Simple.
Propre.
Scalable.
Maintenable.
Professionnel.
