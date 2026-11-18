<?php


namespace iutnc\deefy\dispatch;

use iutnc\deefy\exception\RouterException;
class Dispatcher {
    protected ?string $action = null;
    protected $actions = [];
    public function __construct(){
        $this->action = $_GET['action'] ?? 'default';
    }
    public function addRoute(string $action, string $action_class) : Dispatcher{
        $this->actions[$action] = $action_class;
        return $this;
    }


    public function run(): void {
        try {
            if (!isset($this->actions[$this->action])) {
                throw new RouterException("Action inconnue");
            }
            $class  = $this->actions[$this->action];
            $html   = (new $class())->execute();
        } catch (RouterException $e) {
            http_response_code(404);
            $html = '<h2>Page introuvable</h2>';
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            http_response_code(500);
            $html = '<h2>Une erreur est survenue</h2>';
        }
        $this->renderPage($html);
    }

    private function renderPage(string $html): void {
        $nav = '<a href="?action=default">Accueil</a> | '
            . '<a href="?action=playlists">Mes playlists</a> | '
            . '<a href="?action=playlist">Playlist courante</a> | '
            . '<a href="?action=add-playlist">Créer une playlist</a>';

        echo <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Deefy</title>
        </head>
        <body>
            <header>
                <h1>Deefy</h1>
                <nav>$nav</nav>
            </header>
            <hr>
            <main>$html</main>
        </body>
        </html>
        HTML;
    }

}

