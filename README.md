# TP RIT/SIL — Vérificateur d'anagrammes avec PHP

Application web permettant de vérifier si deux chaînes de caractères sont des anagrammes, avec gestion des utilisateurs et historique personnel des vérifications.

## 📁 Structure du projet

```
tp-anagramme/
├── config.php        # Connexion PDO à MySQL + démarrage de session
├── functions.php     # Fonctions utilitaires (anagramme, validation, redirection)
├── index.php         # Accueil + formulaire de vérification d'anagrammes
├── history.php       # Consultation de l'historique personnel
├── register.php      # Inscription (crée 2 comptes : pseudo + reverse(pseudo))
├── login.php         # Connexion
├── logout.php        # Déconnexion (supprime l'utilisateur de la BDD)
├── style.css         # Mise en forme (inspirée des maquettes du TP)
├── database.sql      # Script de création de la base de données
└── README.md         # Ce fichier
```

## 🚀 Installation et exécution

### 1. Prérequis
- WAMP (ou tout serveur LAMP/WAMP) avec Apache, MySQL et PHP 8.x
- phpMyAdmin (recommandé pour importer la base de données)

### 2. Base de données
1. Lancez WAMP.
2. Ouvrez http://localhost/phpmyadmin
3. Créez une base de données nommée `tp_anagramme` (encodage `utf8mb4_unicode_ci`).
4. Importez le fichier `database.sql` ou exécutez son contenu dans l'onglet SQL.

### 3. Déploiement des fichiers
1. Copiez le dossier `tp-anagramme/` dans le répertoire `www` de WAMP, par exemple :
   ```
   C:\wamp64\www\tp-anagramme\
   ```
2. Vérifiez que `config.php` contient les bons identifiants de connexion MySQL (par défaut WAMP : utilisateur `root`, mot de passe vide).

### 4. Accès à l'application
Ouvrez votre navigateur à l'adresse :
```
http://localhost/tp-anagramme/index.php
```

## 🔐 Règles spécifiques du TP respectées

| Règle | Implémentation |
|-------|----------------|
| Mot de passe non hashé | Storé en clair dans la table `users` |
| Double compte à l'inscription | Création de 2 lignes : le pseudo saisi et son inverse (`strrev`), même mot de passe |
| Suppression à la déconnexion | L'utilisateur et tout son historique sont supprimés de la BDD quand il se déconnecte |
| Historique personnel | Chaque vérification est liée à l'utilisateur connecté (`user_id`) |

## ✅ Fonctionnalités implémentées

- Vérification d'anagrammes (algorithme de tri, complexité O(n log n))
- Bordure verte si anagrammes, bordure rouge sinon
- Gestion des erreurs (champs vides, caractères non autorisés)
- Inscription, connexion, déconnexion
- Sessions PHP pour maintenir l'état de connexion
- Historique des vérifications propre à chaque utilisateur (tableau consultable)

## 📋 Livrables attendus (selon l'énoncé)

1. ✅ Code source complet de l'application
2. ✅ Script SQL de création de la base de données (`database.sql`)
3. À fournir : captures d'écran des différentes fonctionnalités
4. ✅ Fichier d'instructions d'installation et d'exécution (ce fichier `README.md`)
