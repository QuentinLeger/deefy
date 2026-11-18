<?php

namespace iutnc\deefy\repository;

use Exception;
use PDO;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\audio\tracks\PodcastTrack;

class DeefyRepository {

    private static ?array $config= null;
    private static ?DeefyRepository $instance=null;
    private PDO $pdo;

    public function __construct (){
        if (self::$config === null){
            throw new Exception("La config n'a pas été chargée");
        }

        $driver = self::$config['driver'] ?? 'mysql';
        $host = self::$config['host'] ?? 'localhost';
        $database = self::$config['database'] ?? '';
        $user = self::$config['username'] ?? '';
        $pass = self::$config['password'] ?? '';

        $dsn = "{$driver}:host={$host};dbname={$database};charset=utf8";

        $this->pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }


    public static function setConfig (String $file): void{
        $conf = parse_ini_file($file);
        if ($conf === false){
            throw new Exception("Impossible de lire le fichier de configuratino");
        }
        self::$config = $conf;
    }


    public static function getInstance() : DeefyRepository{
        if (self::$instance === null){
            self::$instance = new DeefyRepository();
        }
        return self::$instance;
    }

    public function findAllPlaylists(): array {
        return $this->pdo->query("SELECT id, nom FROM playlist ORDER BY nom")->fetchAll();
    }
    public function findPlaylistById(int $id): ?Playlist {
        $stmt = $this->pdo->prepare("SELECT id, nom FROM playlist WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }

        $pl = new Playlist($row['nom']);
        $pl->setId((int) $row['id']);

        $stmt = $this->pdo->prepare(
            "SELECT t.* FROM track t
             INNER JOIN playlist2track pt ON pt.id_track = t.id
             WHERE pt.id_pl = :id ORDER BY pt.no_piste_dans_liste"
        );
        $stmt->execute(['id' => $id]);

        foreach ($stmt->fetchAll() as $r) {
            $t = new PodcastTrack($r['titre'], $r['filename']);
            $t->setId((int) $r['id']);
            $t->setGenre($r['genre'] ?? '');
            $t->setDuree((int) $r['duree']);
            $t->setAuteur($r['auteur_podcast'] ?? '');
            $t->setDate($r['date_podcast'] ?? '');
            $pl->ajouterPiste($t);
        }
        return $pl;
    }

    public function saveEmptyPlaylist(Playlist $pl): Playlist {
        $stmt = $this->pdo->prepare("INSERT INTO playlist (nom) VALUES (:nom)");
        $stmt->execute(['nom' => $pl->nom]);
        $pl->setId((int) $this->pdo->lastInsertId());
        return $pl;
    }


    public function saveTrack(PodcastTrack $t): PodcastTrack {
        $stmt = $this->pdo->prepare(
            "INSERT INTO track (titre, genre, duree, filename, type, auteur_podcast, date_podcast)
             VALUES (:titre, :genre, :duree, :filename, 'P', :auteur, :date)"
        );
        $stmt->execute([
            'titre'    => $t->titre,
            'genre'    => $t->genre,
            'duree'    => $t->duree,
            'filename' => $t->fichier,
            'auteur'   => $t->auteur,
            'date'     => $t->date === '' ? null : $t->date,
        ]);
        $t->setId((int) $this->pdo->lastInsertId());
        return $t;
    }

    public function addTrackToPlaylist(int $idPl, int $idTrack): void {
        $stmt = $this->pdo->prepare("SELECT COALESCE(MAX(no_piste_dans_liste), 0) + 1 AS n FROM playlist2track WHERE id_pl = :p");
        $stmt->execute(['p' => $idPl]);
        $n = (int) $stmt->fetch()['n'];

        $stmt = $this->pdo->prepare(
            "INSERT INTO playlist2track (id_pl, id_track, no_piste_dans_liste) VALUES (:p, :t, :n)"
        );
        $stmt->execute(['p' => $idPl, 't' => $idTrack, 'n' => $n]);
    }
}
