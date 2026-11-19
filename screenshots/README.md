# Captures d'écran — Livrables du TP

Ce dossier doit contenir les captures d'écran illustrant les différentes fonctionnalités de l'application.

## Captures à réaliser

| Fichier | Fonctionnalité | Description |
|---------|---------------|-------------|
| `01-ecran-initial.png` | Écran initial | Page d'accueil avec formulaire de vérification (Figure 1) |
| `02-formulaire-renseigne.png` | Formulaire rempli | Deux chaînes saisies avant soumission (Figure 2) |
| `03-resultat-positif.png` | Résultat anagrammes | Bordure verte, message "Les deux chaînes sont des anagrammes" |
| `04-resultat-negatif.png` | Résultat pas des anagrammes | Bordure rouge, message "Les deux chaînes ne sont pas des anagrammes" |
| `05-inscription.png` | Inscription | Formulaire de création de compte |
| `06-connexion.png` | Connexion | Formulaire de connexion |
| `07-historique.png` | Historique | Tableau des vérifications personnelles (Figure 5) |
| `08-erreur.png` | Gestion des erreurs | Champ vide ou caractères non autorisés |

## Comment prendre les captures

1. Lance WAMP et ouvre `http://localhost/tp-anagramme/`
2. Utilise l'outil de capture de Windows (`Win + Maj + S`) ou l'outil Capture d'écran
3. Enregistre chaque image avec le nom indiqué dans ce dossier `screenshots/`
4. Les formats acceptés : `.png` (recommandé) ou `.jpg`

Une fois les captures ajoutées, n'oublie pas de les committer sur GitHub :

```powershell
git add screenshots/
git commit -m "Ajout des captures d'écran des fonctionnalités"
git push
```
