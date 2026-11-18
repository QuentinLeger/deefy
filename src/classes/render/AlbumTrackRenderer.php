<?php


namespace iutnc\deefy\render;

use iutnc\deefy\audio\tracks\AlbumTrack;


class AlbumTrackRenderer {
    public AlbumTrack $albumTrack;
    public function __construct(AlbumTrack $albumTrack) {
        $this->albumTrack = $albumTrack;
    }

    public function render(int $selector): string {
        $result = $this->albumTrack->__toString();
        switch ($selector) {
            case 1:
                return "<!DOCTYPE html>\n <html lang=\"fr\">\n<head>\n<meta charset=\"utf-8\">\n<title>TD1-Introduction</title>\n</head>\n<body>\n <p> {$result} </p> \n </body>\n</html>\n";
            default : return "<!DOCTYPE html>\n <html lang=\"fr\">\n<head>\n<meta charset=\"utf-8\">\n<title>TD1-Introduction</title>\n</head>\n<body>\n <p> {$result[0]} </p> \n </body>\n</html>\n";
        }
    }
}