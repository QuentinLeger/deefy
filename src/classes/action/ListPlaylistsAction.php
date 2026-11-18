<?php

namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;

class ListPlaylistsAction extends Action {

    public function execute() : string {
        $playlists = DeefyRepository::getInstance()->findAllPlaylists();
        $html = '<h2>Mes playlists</h2>';
        if (count($playlists) === 0) {
            return $html . '<p>Aucune playlist pour le moment.</p>';
        }

        $html .= '<ul>';
        foreach ($playlists as $p) {
            $html .= '<li><a href="?action=playlist&amp;id=' . (int) $p['id'] . '">'
                . $this->e($p['nom']) . '</a></li>';
        }
        return $html . '</ul>';
    }
}