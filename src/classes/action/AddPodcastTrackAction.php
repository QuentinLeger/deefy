<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;

class AddPodcastTrackAction extends Action {

    public function execute() : string {
        if ($this->http_method === 'GET'){
            return <<<HTML
            <h2>Créer un podcast</h2>
            <form method="post" action="action="?action=add-track"" enctype="multipart/form-data">
                <label>Titre : <input type="text" name="titre" required></label><br>
                <label>Auteur : <input type="text" name="auteur"></label><br>
                <label>Genre : <input type="text" name="genre"></label><br>
                <label>Durée (s) : <input type="number" name="duree" min="0"></label><br>
                <label>Fichier .mp3 : <input type="file" name="fichier" accept=".mp3,audio/mpeg" required></label><br>
                <button type="submit">Ajouter</button>
            </form>
            HTML;
        }

        if (!isset($_SESSION['playlist'])) {
            return '<p>Erreur : aucune playlist trouvée en session.</p>';
        }

        $titre = trim($_POST['titre'] ?? '');
        $auteur = trim($_POST['auteur'] ?? '');
        $genre = trim($_POST['genre'] ?? '');
        $duree = filter_var($_POST['duree'] ?? 0, FILTER_VALIDATE_INT);



        if ($titre === '' || $duree === false || $duree < 0) {
            return '<p>Données du formulaire invalides.</p>';
        }

        if (!isset($_FILES['fichier']) || $_FILES['fichier']['error'] !== UPLOAD_ERR_OK) {
            return '<p>Erreur lors du transfert du fichier audio.</p>';
        }

        $file = $_FILES['fichier'];

        $ext = strtolower(substr($file['name'], -4));
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        if ($ext !== '.mp3' || $mime !== 'audio/mpeg') {
            return '<p>Format de fichier invalide : seul le format .mp3 est autorisé.</p>';
        }


        $nomAleatoire = uniqid('track_',true) . '.mp3';
        $dest = 'audio/' . $nomAleatoire;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            return '<p>Échec de l\'enregistrement du fichier audio.</p>';
        }

        $track = new PodcastTrack($titre, $nomAleatoire);
        $track -> setAuteur($auteur);
        $track-> setGenre($genre);
        $track-> setDuree($duree);


        $pl = $_SESSION['playlist'];
        $repo = DeefyRepository::getInstance();
        $repo->saveTrack($track);
        $repo->addTrackToPlaylist($pl->id, $track->id);

        $pl->ajouterPiste($track);
        $_SESSION['playlist'] = $pl;

        $renderer = new AudioListRenderer($pl);
        return $renderer->render() . '<a href="?action=add-track">Ajoute encore une piste</a>';
    }
}