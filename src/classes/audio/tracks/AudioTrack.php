<?php

namespace iutnc\deefy\audio\tracks;

use iutnc\deefy\exception\InvalidPropertyValueException;
use iutnc\deefy\exception\InvalidPropertyNameException;



class AudioTrack
{
    protected string $titre;
    protected string $genre = '';
    protected int $duree = 0;
    protected string $fichier;

    protected ?int $id = null;

    public function __construct(string $titre, string $fichier)
    {
        $this->titre = $titre;
        $this->fichier = $fichier;
    }

    public function __get(string $name): mixed
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new InvalidPropertyNameException("invalid property : {$name}");
    }

    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }

    public function setDuree(int $duree): void
    {
        if ($duree < 0) {
            throw new InvalidPropertyValueException("invalid property value : la duree ne peut pas etre negative ({$duree})");
        }
        $this->duree = $duree;
    }

    public function __toString(): string
    {
        return json_encode(get_object_vars($this));
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}