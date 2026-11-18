<?php


namespace iutnc\deefy\render;

use iutnc\deefy\audio\lists\AudioList;


class AudioListRenderer implements Renderer
{
    protected AudioList $audioList;

    public function __construct(AudioList $audioList)
    {
        $this->audioList = $audioList;
    }

    public function render(int $selector = self::COMPACT): string
    {
        $html = "<div class=\"audio-list\">\n";
        $html .= "  <h3>" . htmlspecialchars($this->audioList->nom, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</h3>\n";
        $html .= "  <div class=\"tracks\">\n";

        foreach ($this->audioList->pistes as $piste) {
            $pisteRenderer = new AudioTrackRenderer($piste);
            $html .= "    " . $pisteRenderer->render(self::COMPACT);
        }

        $html .= "  </div>\n";
        $html .= "  <p>Nombre de pistes : " . (int) $this->audioList->nbPistes . " | Durée totale : " . (int) $this->audioList->dureeTotale . "s</p>\n";
        $html .= "</div>\n";

        return $html;
    }
}