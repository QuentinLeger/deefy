<?php

namespace iutnc\deefy\render;
use iutnc\deefy\audio\tracks\AudioTrack;


class AudioTrackRenderer implements Renderer
{
    protected AudioTrack $track;

    public function __construct(AudioTrack $track)
    {
        $this->track = $track;
    }

    public function render(int $selector = self::COMPACT): string
    {
        $titre = htmlspecialchars($this->track->titre, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $duree = (int) $this->track->duree;
        $src   = htmlspecialchars('audio/' . $this->track->fichier, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        return "<div class=\"track\"><p>{$titre} ({$duree}s)</p>"
            . "<audio controls src=\"{$src}\"></audio></div>\n";
    }
}