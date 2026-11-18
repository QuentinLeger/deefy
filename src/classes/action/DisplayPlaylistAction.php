<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;

class DisplayPlaylistAction extends Action {

    public function execute() : string {
        if (isset($_GET['id'])) {

            $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
            if ($id === false) {
                return '<p>Identifiant de playlist invalide.</p>';
            }
            $pl = DeefyRepository::getInstance()->findPlaylistById($id);
            if ($pl === null) {
                return '<p>Playlist introuvable.</p>';
            }
            $_SESSION['playlist'] = $pl;
        } else {

            $pl = $_SESSION['playlist'] ?? null;
            if (!($pl instanceof Playlist)) {
                return '<p>Aucune playlist courante. <a href="?action=playlists">Choisir une playlist</a></p>';
            }
        }

        return (new AudioListRenderer($pl))->render()
            . '<p><a href="?action=add-track">Ajouter une piste</a></p>';
    }
}