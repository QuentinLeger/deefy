DROP TABLE IF EXISTS playlist2track;
DROP TABLE IF EXISTS track;
DROP TABLE IF EXISTS playlist;

CREATE TABLE playlist (
id INT AUTO_INCREMENT PRIMARY KEY,
nom VARCHAR(100) NOT NULL
);

CREATE TABLE track (
id INT AUTO_INCREMENT PRIMARY KEY,
titre VARCHAR(100) NOT NULL,
genre VARCHAR(30),
duree INT NOT NULL DEFAULT 0,
filename VARCHAR(255) NOT NULL,
type VARCHAR(30) NOT NULL DEFAULT 'P',
auteur_podcast VARCHAR(100),
date_podcast DATE
);

CREATE TABLE playlist2track (
id_pl INT NOT NULL,
id_track INT NOT NULL,
no_piste_dans_liste INT NOT NULL,
PRIMARY KEY (id_pl, id_track)
);

INSERT INTO playlist (nom) VALUES ('Ma première playlist'), ('Playlist vide');
INSERT INTO track (titre, genre, duree, filename, auteur_podcast, date_podcast)
VALUES ('Podcast de test', 'Divers', 30, '6ac5f7ab894d2.mp3', 'Moi', '2026-10-07');
INSERT INTO playlist2track (id_pl, id_track, no_piste_dans_liste) VALUES (1, 1, 1);