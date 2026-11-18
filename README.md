# Deefy
**Auteur :** LEGER Quentin 
**Site en ligne :** https://webetu.iutnc.univ-lorraine.fr/www/e52366u/deefy/execute.php

## Tableau de bord
| # | Fonctionnalité | Action | Réalisée |
|---|---|---|---|
| 1 | Mes playlists | `?action=playlists` | Oui |
| 2 | Afficher une playlist (devient la courante) | `?action=playlist&id=N` | Oui |
| 3 | Ajouter une piste à la playlist courante | `?action=add-track` | Oui |
| 4 | Créer une playlist vide | `?action=add-playlist` | Oui |
| 5 | Afficher la playlist courante | `?action=playlist` | Oui |

## Sécurité
* **Injections SQL :** Requêtes préparées via PDO.
* **Failles XSS :** Échappement systématique des affichages avec `htmlspecialchars()`.

## Base de données & Installation locale
* **Script SQL :** `sql/deefy.sql` (base du TD utilisée telle quelle)