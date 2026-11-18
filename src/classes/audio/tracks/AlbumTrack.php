<?php


namespace iutnc\deefy\audio\tracks;

class AlbumTrack extends AudioTrack
{
    protected string $artiste = '';
    protected string $album;
    protected int $numeroPiste;

    public function __construct(string $titre, string $fichier, string $album, int $numeroPiste)
    {
        parent::__construct($titre, $fichier);
        $this->album = $album;
        $this->numeroPiste = $numeroPiste;
    }

    public function setArtiste(string $artiste): void
    {
        $this->artiste = $artiste;
    }
}