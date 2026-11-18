# Deefy
**Auteur :** LEGER Quentin
**Site en ligne :** https://webetu.iutnc.univ-lorraine.fr/www/e52366u/deefy/execute.php

## Tableau de bord des fonctionnalités
| # | Fonctionnalité | Action / Route | Réalisée | Notes |
|---|---|---|---|---|
| 1 | Mes playlists | `?action=playlists` | Oui | Liste toutes les playlists enregistrées en BD |
| 2 | Afficher une playlist | `?action=playlist&id=N` | Oui | Définit la playlist sélectionnée comme playlist courante en session |
| 3 | Ajouter une piste | `?action=add-track` | Oui | Formulaire d'ajout + upload fichier audio MP3 dans `audio/` |
| 4 | Créer une playlist vide | `?action=add-playlist` | Oui | Enregistrement en BD et mise en session comme playlist courante |
| 5 | Afficher la playlist courante | `?action=playlist` | Oui | Affiche la playlist actuellement stockée en session |

## Éléments de test
* **Jeu de données :** La base de données Webetu est déjà initialisée avec les playlists et pistes d'exemple issues du script `sql/deefy.sql`.
* **Test d'upload :** L'ajout d'une piste accepte tout fichier au format `.mp3` (enregistré dans le répertoire `audio/`).

## Sécurité et conformité
* **Injections SQL :** Utilisation systématique de requêtes préparées via PDO.
* **Failles XSS :** Échappement de toutes les données affichées via `htmlspecialchars()`.
* **Validation W3C :** Code HTML généré contrôlé sur le validateur W3C.

## Base de données & Installation locale
* **Script SQL :** `sql/deefy.sql` (structure identique à celle des TD, non modifiée).
* **Déploiement local :**
    1. Exécuter `composer install` à la racine du projet.
    2. Importer `sql/deefy.sql` dans la base MySQL.
    3. Configurer `src/config/db.config.ini`.
    4. Donner les droits d'écriture sur le dossier `audio/`.