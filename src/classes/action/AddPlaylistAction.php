<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;

class AddPlaylistAction extends Action {

    public function execute(): string {
        $form = <<< HTML
            <h2>Créer une playlist</h2>
            <form method="post" action="?action=add-playlist">
            <p><label>Nom : <input type="text" name="nom" maxlength="100" required></label></p>
            <p><button type="submit">Créer</button></p>
             </form>
            HTML;


        if ($this->http_method === 'GET') {
            return $form;
        }

        // On stocke la donnée brute ; l'échappement se fait à l'affichage
        $nom = trim($_POST['nom'] ?? '');
        if ($nom === '' || strlen($nom) > 100) {
            return '<p>Nom de playlist invalide (1 à 100 caractères).</p>' . $form;
        }

        $pl = DeefyRepository::getInstance()->saveEmptyPlaylist(new Playlist($nom));
        $_SESSION['playlist'] = $pl;

        return (new AudioListRenderer($pl))->render()
            . '<p><a href="?action=add-track">Ajouter une piste</a></p>';
    }
}