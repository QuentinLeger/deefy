<?php

require_once 'vendor/autoload.php';   // ou ton autoloader
session_start();
use iutnc\deefy\dispatch\Dispatcher;
use iutnc\deefy\action\DefaultAction;
use iutnc\deefy\action\ListPlaylistsAction;
use iutnc\deefy\action\DisplayPlaylistAction;
use iutnc\deefy\action\AddPlaylistAction;
use iutnc\deefy\action\AddPodcastTrackAction;
use iutnc\deefy\repository\DeefyRepository;



\iutnc\deefy\repository\DeefyRepository::setConfig(__DIR__ . '/src/config/db.config.ini');

$router = new Dispatcher();
$router->addRoute('default', DefaultAction::class)
    ->addRoute('playlists', ListPlaylistsAction::class)
    ->addRoute('playlist', DisplayPlaylistAction::class)
    ->addRoute('add-playlist', AddPlaylistAction::class)
    ->addRoute('add-track', AddPodcastTrackAction::class);
$router->run();