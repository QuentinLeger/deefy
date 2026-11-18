<?php


namespace iutnc\deefy\audio\lists;
use iutnc\deefy\exception\InvalidPropertyNameException;


class AudioList implements \Iterator
{
    protected string $nom;
    protected int $nbPistes = 0;
    protected int $dureeTotale = 0;

    protected array $pistes = [];

    private int $position = 0;
    protected ?int $id = null;


    public function __construct(string $nom, array $pistes = [])
    {
        $this->nom = $nom;
        $this->pistes = $pistes;
        $this->nbPistes = count($pistes);

        foreach ($pistes as $piste) {
            $this->dureeTotale += $piste->duree;
        }
    }

    public function __get(string $name): mixed
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new InvalidPropertyNameException("invalid property : {$name}");
    }

    public function current(): mixed {
        return $this->pistes[$this->position];
    }

    public function key(): mixed
    {
        return $this->position;
    }

    public function next(): void
    {
        $this->position++;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->pistes[$this->position]);
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}